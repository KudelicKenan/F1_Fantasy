# Formula 1 Fantasy - Web Aplikacija za Upravljanje Fantasy Timovima

## Apstrakt

Ova aplikacija predstavlja kompletan web sistem za upravljanje fantasy timovima u kontekstu Formule 1. Implementirana je koristeći Laravel framework (verzija 12.0), koji omogućava razvoj robustnih web aplikacija sa MVC arhitekturom. Sistem obuhvata autentifikaciju korisnika, CRUD operacije nad entitetima, integraciju sa eksternim API servisima, i RESTful API za pristup podacima.

## 1. Uvod

### 1.1 Pregled Projekta

Formula 1 Fantasy aplikacija je dizajnirana da omogući korisnicima kreiranje i upravljanje svojim fantasy timovima, praćenje performansi vozača i timova, te dobijanje vremenskih informacija za trke. Aplikacija implementira moderne web development prakse uključujući autentifikaciju, autorizaciju, file handling, i integraciju sa eksternim servisima.

### 1.2 Tehnologije i Alati

- **Backend Framework**: Laravel 12.0
- **Programski jezik**: PHP 8.2+
- **Frontend**: Laravel Blade templating engine, TailwindCSS
- **Autentifikacija**: Laravel Fortify, Laravel Socialite
- **Baza podataka**: MySQL/SQLite (konfigurabilno)
- **Eksterni API**: OpenWeatherMap API
- **Version Control**: Git/GitHub

## 2. Arhitektura Sistema

### 2.1 Model-View-Controller (MVC) Pattern

Aplikacija prati MVC arhitekturni obrazac:

- **Models**: Eloquent ORM modeli (`Driver`, `Team`, `Race`, `FantasyTeam`, `User`)
- **Views**: Blade template fajlovi za prikaz podataka
- **Controllers**: HTTP kontroleri za obradu zahteva (`DriverController`, `TeamController`, `RaceController`, `FantasyTeamController`, `WeatherController`)

### 2.2 Baza Podataka

Sistem koristi relacioni model sa sledećim entitetima:

1. **users** - Korisnici sistema
2. **drivers** - Vozači Formule 1 sa atributima (ime, nacionalnost, datum rođenja, tim, poeni, fotografija)
3. **teams** - Timovi sa atributima (ime, država, godina osnivanja, logo, ukupni poeni)
4. **races** - Trke sa atributima (ime, lokacija, datum, naziv staze, vremenske prilike, broj krugova)
5. **fantasy_teams** - Fantasy timovi korisnika
6. **fantasy_team_drivers** - Pivot tabela za many-to-many relaciju između fantasy timova i vozača

### 2.3 Relacije između Entiteta

- `User` hasMany `FantasyTeam`
- `Team` hasMany `Driver`
- `Driver` belongsTo `Team`
- `FantasyTeam` belongsToMany `Driver` (preko pivot tabele)
- `Driver` belongsToMany `FantasyTeam` (preko pivot tabele)

## 3. Funkcionalnosti

### 3.1 Autentifikacija i Autorizacija

Sistem implementira višeslojnu autentifikaciju:

- **Standardna autentifikacija**: Email i lozinka (Laravel Fortify)
- **OAuth 2.0 autentifikacija**: Integracija sa Google i GitHub (Laravel Socialite)
- **Session-based autentifikacija**: Za web interfejs
- **Middleware zaštita**: Za zaštićene rute

### 3.2 CRUD Operacije

Implementirane su kompletne CRUD operacije za sledeće entitete:

- **Drivers**: Kreiranje, čitanje, ažuriranje, brisanje vozača
- **Teams**: Upravljanje timovima
- **Races**: Upravljanje trkama
- **Fantasy Teams**: Kreiranje i upravljanje fantasy timovima sa mogućnošću dodavanja/uklanjanja vozača

### 3.3 File Handling

Sistem podržava upload i upravljanje fajlovima:

- Upload fotografija vozača (JPEG, PNG, JPG, GIF, max 2MB)
- Upload logotipa timova
- Automatsko brisanje starih fajlova pri ažuriranju
- Simbolički linkovi za pristup fajlovima (`storage:link`)

### 3.4 Statistike i Agregacija Podataka

Dashboard prikazuje agregirane statistike:

- Ukupan broj vozača, timova, trka, fantasy timova
- Najbolji vozač po poenima
- Najbolji tim po poenima
- Prosečne vrednosti i rangiranje

### 3.5 RESTful API

Implementiran je RESTful API sa sledećim karakteristikama:

- **Zaštićeni endpointi**: Zahtevaju autentifikaciju (`auth` middleware)
- **Javni endpointi**: Dostupni bez autentifikacije (`/api/public/*`)
- **JSON response format**: Standardizovani JSON odgovori
- **Paginacija**: Za liste entiteta
- **Sortiranje**: Po različitim atributima (poeni, datum, itd.)

### 3.6 Eksterni API Integracija

Integracija sa OpenWeatherMap API:

- Automatsko dohvatanje vremenskih prilika za lokacije trka
- Ažuriranje vremenskih podataka u bazi
- Error handling za API greške (401, 404, 429)
- Logging API zahteva i odgovora

## 4. Instalacija i Konfiguracija

### 4.1 Preduslovi

- PHP 8.2 ili noviji
- Composer
- Node.js i npm
- MySQL ili SQLite
- Git

### 4.2 Koraci Instalacije

#### Korak 1: Kloniranje Repozitorijuma

```bash
git clone https://github.com/[username]/fantasyf1.git
cd fantasyf1
```

#### Korak 2: Instalacija Dependencies

```bash
composer install
npm install
```

#### Korak 3: Konfiguracija Okruženja

Kopirajte `.env.example` u `.env`:

```bash
cp .env.example .env
php artisan key:generate
```

Konfigurišite bazu podataka u `.env` fajlu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fantasyf1
DB_USERNAME=root
DB_PASSWORD=
```

Za SQLite:

```env
DB_CONNECTION=sqlite
```

Kreirajte SQLite bazu:

```bash
touch database/database.sqlite
```

#### Korak 4: Migracije i Seed Podaci

```bash
php artisan migrate
php artisan db:seed
```

#### Korak 5: Storage Link

```bash
php artisan storage:link
```

#### Korak 6: Pokretanje Aplikacije

```bash
php artisan serve
npm run dev
```

Aplikacija će biti dostupna na `http://localhost:8000`

### 4.3 Konfiguracija Eksternih Servisa

#### Google OAuth

1. Kreirajte projekat na [Google Cloud Console](https://console.cloud.google.com/)
2. Omogućite Google+ API
3. Kreirajte OAuth 2.0 Client ID
4. Dodajte redirect URI: `http://localhost:8000/auth/google/callback`
5. Dodajte u `.env`:

```env
GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

#### GitHub OAuth

1. Idite na GitHub Settings > Developer settings > OAuth Apps
2. Kliknite "New OAuth App"
3. Unesite Application name i Homepage URL
4. Authorization callback URL: `http://localhost:8000/auth/github/callback`
5. Dodajte u `.env`:

```env
GITHUB_CLIENT_ID=your_client_id
GITHUB_CLIENT_SECRET=your_client_secret
GITHUB_REDIRECT_URI=http://localhost:8000/auth/github/callback
```

#### OpenWeatherMap API

1. Registrujte se na [OpenWeatherMap](https://openweathermap.org/api)
2. Idite na API keys sekciju
3. Kopirajte API key
4. Dodajte u `.env`:

```env
WEATHER_API_KEY=your_api_key
```

## 5. API Dokumentacija

### 5.1 Zaštićeni Endpointi (zahtevaju autentifikaciju)

#### Drivers CRUD

```
GET    /api/drivers              - Lista svih vozača
GET    /api/drivers/{id}         - Pojedinačni vozač
POST   /api/drivers              - Kreiraj vozača
PUT    /api/drivers/{id}         - Ažuriraj vozača
DELETE /api/drivers/{id}         - Obriši vozača
```

#### Statistics

```
GET /api/statistics              - Ukupne statistike
GET /api/statistics/drivers      - Statistike vozača
GET /api/statistics/teams        - Statistike timova
GET /api/statistics/fantasy-teams - Statistike fantasy timova
```

#### Weather API

```
GET  /api/races/{raceId}/weather - Vremenske prilike za trku
POST /api/races/update-weather   - Ažuriraj vremenske prilike za sve trke
```

### 5.2 Javni Endpointi (bez autentifikacije)

```
GET /api/public/drivers          - Lista vozača
GET /api/public/drivers/{id}     - Pojedinačni vozač
GET /api/public/teams            - Lista timova
GET /api/public/teams/{id}       - Pojedinačni tim
GET /api/public/races            - Lista trka
GET /api/public/races/{id}       - Pojedinačna trka
GET /api/public/stats            - Osnovne statistike
```

### 5.3 Primeri Zahteva

#### Lista vozača sa sortiranjem

```bash
GET /api/public/drivers?sort_by=points&sort_order=desc
```

#### Kreiranje vozača (zahtevaju autentifikaciju)

```bash
POST /api/drivers
Content-Type: multipart/form-data

{
    "name": "Lewis Hamilton",
    "nationality": "British",
    "date_of_birth": "1985-01-07",
    "team_id": 1,
    "points": 250,
    "driver_number": 44,
    "photo": [file]
}
```

## 6. Struktura Projekta

```
fantasyf1/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── DriverController.php
│   │       ├── TeamController.php
│   │       ├── RaceController.php
│   │       ├── FantasyTeamController.php
│   │       ├── DashboardController.php
│   │       ├── WeatherController.php
│   │       ├── StatisticsController.php
│   │       └── Auth/
│   │           └── SocialiteController.php
│   └── Models/
│       ├── User.php
│       ├── Driver.php
│       ├── Team.php
│       ├── Race.php
│       └── FantasyTeam.php
├── database/
│   ├── migrations/
│   │   ├── *_create_users_table.php
│   │   ├── *_create_drivers_table.php
│   │   ├── *_create_teams_table.php
│   │   ├── *_create_races_table.php
│   │   ├── *_create_fantasy_teams_table.php
│   │   └── *_create_fantasy_team_drivers_table.php
│   ├── factories/
│   │   ├── DriverFactory.php
│   │   ├── TeamFactory.php
│   │   ├── RaceFactory.php
│   │   └── FantasyTeamFactory.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── TeamSeeder.php
│       ├── DriverSeeder.php
│       ├── RaceSeeder.php
│       ├── FantasyTeamSeeder.php
│       └── FantasyTeamDriverSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── drivers/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── show.blade.php
│   │   ├── teams/
│   │   ├── races/
│   │   ├── fantasy-teams/
│   │   └── dashboard.blade.php
│   └── js/
│       └── pages/
│           └── auth/
│               ├── login.tsx
│               └── register.tsx
├── routes/
│   ├── web.php
│   └── api.php
├── storage/
│   └── app/
│       └── public/
│           ├── drivers/
│           └── teams/
├── .env.example
├── .gitignore
├── composer.json
├── package.json
└── README.md
```

## 7. Testiranje

### 7.1 Web Interfejs

Pristupite aplikaciji preko web browsera na `http://localhost:8000` i testirajte funkcionalnosti kroz korisnički interfejs.

### 7.2 API Testiranje

Za testiranje API endpointa koristite:

- **Insomnia** ili **Postman** za HTTP zahteve
- **cURL** za command-line testiranje

#### Primer: Testiranje javnog endpointa

```bash
curl http://localhost:8000/api/public/drivers
```

#### Primer: Testiranje zaštićenog endpointa sa session cookie

1. Prijavite se preko web interfejsa
2. Kopirajte `laravel_session` cookie iz browsera
3. Koristite cookie u zahtevu:

```bash
curl http://localhost:8000/api/drivers \
  -H "Cookie: laravel_session=YOUR_SESSION_COOKIE"
```

## 8. Razvoj i Održavanje

### 8.1 Komande za Razvoj

```bash
# Pokreni migracije
php artisan migrate

# Resetuj bazu i pokreni seed
php artisan migrate:fresh --seed

# Kreiraj storage link
php artisan storage:link

# Očisti cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Pokreni server
php artisan serve

# Pokreni Vite dev server
npm run dev
```

### 8.2 Seed Podaci

Seederi kreiraju sledeće podatke:

- 10 timova
- 20 vozača (2 po timu)
- 15 trka
- Fantasy timove za postojeće korisnike
- Povezivanje vozača sa fantasy timovima


## 9. Zaključak

Ova aplikacija predstavlja kompletan web sistem za upravljanje fantasy timovima Formule 1, implementiran koristeći moderne web development prakse i Laravel framework. Sistem obuhvata sve tražene funkcionalnosti uključujući autentifikaciju, CRUD operacije, file handling, statistike, i integraciju sa eksternim API servisima.

## 10. Reference

- [Laravel Dokumentacija](https://laravel.com/docs)
- [Laravel Fortify](https://laravel.com/docs/fortify)
- [Laravel Socialite](https://laravel.com/docs/socialite)
- [OpenWeatherMap API](https://openweathermap.org/api)
- [Eloquent ORM](https://laravel.com/docs/eloquent)

## 11. Licenca

Ovaj projekat je kreiran u edukativne svrhe.

---

**Autor**: Kenan Kudelić 
**Datum**: 11.1.2026 
**Verzija**: 1.0.0
