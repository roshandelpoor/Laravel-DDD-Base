<?php

declare(strict_types=1);

use App\Contexts\Chat\Interfaces\Http\Controllers\GetConversationController;
use App\Contexts\Chat\Interfaces\Http\Controllers\SendMessageController;
use Illuminate\Support\Facades\Route;

Route::post('messages', SendMessageController::class)->name('messages.send');
Route::get('conversations/{userA}/{userB}', GetConversationController::class)->name('conversations.show');
