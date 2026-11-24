# Irányítószám REST API (Laravel)

Települések irányítószámai: keresés, megyék szerinti szűrés, adatmódosítás Bearer tokennel (Laravel Sanctum).

## Telepítés

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Az API a `http://localhost:8000/api` címen érhető el.

## Végpontok

| Metódus | Végpont | Token? | Leírás |
|---|---|---|---|
| POST | `/register` | nem | Regisztráció, tokent ad vissza |
| POST | `/login` | nem | Bejelentkezés, tokent ad vissza |
| GET | `/megyek` | nem | Megyék listája |
| GET | `/telepulesek` | nem | Települések listája; szűrők: `search`, `megye_id` |
| GET | `/telepulesek/{id}` | nem | Egy település |
| POST | `/telepulesek` | igen | Új település felvétele |
| PUT | `/telepulesek/{id}` | igen | Település módosítása |
| DELETE | `/telepulesek/{id}` | igen | Település törlése |

Keresés és szűrés példa:

```
GET /api/telepulesek?search=szent
GET /api/telepulesek?megye_id=14
```

Az adatmódosító végpontokhoz a `/login` vagy `/register` által visszaadott tokent kell küldeni: `Authorization: Bearer <token>`.

## APIDOC

A dokumentáció a `docs/index.html` fájlban található. Újragenerálás:

```bash
npx apidoc -i app/Http/Controllers -o docs
```
