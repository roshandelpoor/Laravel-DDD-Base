# Laravel DDD Base

A Laravel 13 starter project structured around **Domain-Driven Design** — use it as the base for new projects.

- Laravel `^13` · PHP `^8.3`
- Bounded contexts under `app/Contexts/`, namespaced `App\Contexts\`
- Layered (onion) architecture per context: `Domain` → `Application` → `Infrastructure` / `Interfaces`

## Architecture

```
app/
├── Contexts/                      # Bounded contexts + shared kernel (all domain code)
│   ├── Shared/                    # Shared kernel — code usable by every context
│   │   ├── Domain/
│   │   │   ├── Event/             #   DomainEvent contract, DomainEventDispatcher port,
│   │   │   │                      #     RecordsDomainEvents trait (for aggregates)
│   │   │   ├── Exception/         #   DomainException + EntityNotFoundException bases
│   │   │   └── ValueObject/       #   UuidValueObject base class
│   │   └── Infrastructure/
│   │       ├── Event/             #   LaravelDomainEventDispatcher adapter
│   │       └── Providers/         #   SharedServiceProvider
│   │
│   ├── Identity/                  # Example bounded context (user management)
│   │   ├── Domain/                #   PURE PHP — no Laravel/framework imports
│   │   │   ├── Entity/User.php    #     Aggregate root
│   │   │   ├── ValueObject/       #     UserId, Email, HashedPassword
│   │   │   ├── Repository/        #     UserRepository port (interface)
│   │   │   ├── Service/           #     PasswordHasher port (interface)
│   │   │   ├── Event/             #     UserRegistered domain event
│   │   │   └── Exception/         #     Domain exceptions
│   │   ├── Application/           #   Use cases (orchestration only)
│   │   │   ├── UseCase/           #     RegisterUser, GetUser
│   │   │   └── Dto/               #     Input/output DTOs
│   │   ├── Infrastructure/        #   Adapters — Laravel/Eloquent lives here
│   │   │   ├── Persistence/Eloquent/ #  UserEloquentModel + EloquentUserRepository
│   │   │   ├── Hashing/           #     LaravelPasswordHasher
│   │   │   └── Providers/         #     IdentityServiceProvider (bindings + routes)
│   │   └── Interfaces/            #   Delivery mechanisms
│   │       └── Http/              #     Controllers, Requests, Resources, routes.php
│   │
│   ├── Payment/                   # Same layout + PaymentGateway port (FakePaymentGateway adapter)
│   ├── Chat/                      # Same layout (Message aggregate)
│   ├── Doctor/                    # Same layout — references Clinic by id only (clinic_id)
│   └── Clinic/                    # Same layout
│
├── Http/Controllers/              # Laravel base controller
└── Providers/                     # AppServiceProvider (app-wide bindings, not per-context)
```

### Bounded contexts

| Context  | Aggregate | Use cases                    | Notes                                              |
|----------|-----------|------------------------------|----------------------------------------------------|
| Identity | User      | RegisterUser, GetUser        | Auth model + `PasswordHasher` port                 |
| Payment  | Payment   | CreatePayment, GetPayment    | `PaymentGateway` port → `FakePaymentGateway` stub  |
| Chat     | Message   | SendMessage, GetConversation | Conversation = messages between two user ids       |
| Doctor   | Doctor    | RegisterDoctor, GetDoctor    | `clinic_id` → Clinic by id only                    |
| Clinic   | Clinic    | RegisterClinic, GetClinic    |                                                    |

### Dependency rule

Dependencies point **inward** only:

```
Interfaces ──▶ Application ──▶ Domain ◀── Infrastructure
```

- `Domain` — entities, value objects, repository/service **ports**, events, exceptions. **Zero framework imports.**
- `Application` — use cases + DTOs. Depends only on Domain contracts.
- `Infrastructure` — implements Domain ports (Eloquent repos, hashers, external APIs). Contains each context's `ServiceProvider`, which binds ports → adapters and loads routes.
- `Interfaces` — HTTP controllers, form requests, resources (and later: CLI commands, jobs, listeners).
- `app/Providers/AppServiceProvider` — app-wide Laravel bindings only; **never** move it into a context — contexts get their own `*ServiceProvider` under `Infrastructure/Providers`.

### Conventions in this base

- **Aggregate roots** use the shared `RecordsDomainEvents` trait: record with `record()`, release with `pullDomainEvents()` after the repository saves; construction via named constructors (`User::register()`, `User::reconstitute()`).
- **IDs are UUIDs** (`UuidValueObject`), and migrations use `uuid` columns.
- **Cross-context references** use plain UUID strings (`Doctor::$clinicId`, `Message::$senderId`) — contexts never import each other's classes.
- **Domain exceptions** extend `App\Contexts\Shared\Domain\Exception\DomainException` (→ 422) or `EntityNotFoundException` (→ 404); `InvalidArgumentException` maps to 400. All mapped once in `bootstrap/app.php`.
- **Ports are bound** in each context's `Infrastructure/Providers/*ServiceProvider`, registered in `bootstrap/providers.php`.
- **Routes per context** live in `Interfaces/Http/routes.php` and are loaded by the context provider under the `api` middleware group.

## Adding a new bounded context

1. Create `app/Contexts/<Context>/{Domain,Application,Infrastructure,Interfaces}` mirroring `Identity`.
2. Write the Domain first: entity, value objects, `*Repository` port, exceptions.
3. Add `Application/UseCase/*` + DTOs.
4. Add the Eloquent model + repository adapter under `Infrastructure/Persistence/Eloquent`.
5. Create `Infrastructure/Providers/<Context>ServiceProvider` that binds ports and loads `Interfaces/Http/routes.php`.
6. Register the provider in `bootstrap/providers.php`.
7. Exceptions extending `DomainException` (→ 422) or `EntityNotFoundException` (→ 404) are mapped automatically — only add a `bootstrap/app.php` renderer for exception types outside the shared bases.
8. Add a feature test under `tests/Feature/<Context>/` and a migration for the table.

## API

| Method | Endpoint                             | Context  | Description              |
|--------|--------------------------------------|----------|--------------------------|
| POST   | `/api/users`                         | Identity | Register a user (201)    |
| GET    | `/api/users/{id}`                    | Identity | Fetch a user by UUID     |
| POST   | `/api/payments`                      | Payment  | Initiate a payment (201) |
| GET    | `/api/payments/{id}`                 | Payment  | Fetch a payment by UUID  |
| POST   | `/api/messages`                      | Chat     | Send a message (201)     |
| GET    | `/api/conversations/{userA}/{userB}` | Chat     | List conversation        |
| POST   | `/api/doctors`                       | Doctor   | Register a doctor (201)  |
| GET    | `/api/doctors/{id}`                  | Doctor   | Fetch a doctor by UUID   |
| POST   | `/api/clinics`                       | Clinic   | Register a clinic (201)  |
| GET    | `/api/clinics/{id}`                  | Clinic   | Fetch a clinic by UUID   |

```sh
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{"name":"Jane","email":"jane@example.com","password":"secret1234"}'
```

## Commands

```sh
php artisan serve          # dev server
php artisan test           # PHPUnit suite
php artisan migrate:fresh  # rebuild DB (sqlite by default)
```

### Code quality

```sh
# Format code (Laravel preset) — fixes files in place
.\vendor\bin\pint              # or: make pint
.\vendor\bin\pint --test       # check only, no changes

# Static analysis (larastan, level 5 — configured in phpstan.neon for app/ + database/)
.\vendor\bin\phpstan analyse --memory-limit=1G   # or: make analyse
```

Makefile shortcuts:

```sh
make pint      # .\vendor\bin\pint
make analyse   # .\vendor\bin\phpstan analyse --memory-limit=1G
```

`make` needs GNU Make — preinstalled on most Linux distros
(`sudo apt install make` / `sudo dnf install make` if missing).
On Windows install it once:

```powershell
winget install ezwinports.make
```

After installing, open a **new** terminal (Windows loads PATH at startup),
or refresh PATH in the current session:

```powershell
$env:Path = [System.Environment]::GetEnvironmentVariable('Path','Machine') + ';' + [System.Environment]::GetEnvironmentVariable('Path','User')
```

## Tests

`tests/Feature/{Identity,Payment,Chat,Doctor,Clinic}/` — each suite covers the full vertical slice: HTTP → use case → repository → database, including the domain events (23 tests).
