.PHONY: pint analyse

pint:
	.\vendor\bin\pint

analyse:
	.\vendor\bin\phpstan analyse --memory-limit=1G
