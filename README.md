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


## 4. Struktura Projekta

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


## 5. Zaključak

Ova aplikacija predstavlja kompletan web sistem za upravljanje fantasy timovima Formule 1, implementiran koristeći moderne web development prakse i Laravel framework. Sistem obuhvata sve tražene funkcionalnosti uključujući autentifikaciju, CRUD operacije, file handling, statistike, i integraciju sa eksternim API servisima.

## 6. Reference

- [Laravel Dokumentacija](https://laravel.com/docs)
- [Laravel Fortify](https://laravel.com/docs/fortify)
- [Laravel Socialite](https://laravel.com/docs/socialite)
- [OpenWeatherMap API](https://openweathermap.org/api)
- [Eloquent ORM](https://laravel.com/docs/eloquent)

## 7. Licenca

Ovaj projekat je kreiran u edukativne svrhe.

---

**Autor**: Kenan Kudelić 
**Datum**: 11.1.2026 
**Verzija**: 1.0.0
