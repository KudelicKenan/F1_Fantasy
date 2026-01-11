# Uputstvo za Postavljanje Projekta na GitHub

## Korak 1: Priprema Projekta

### 1.1 Proverite .gitignore

Proverite da li je `.gitignore` fajl ispravno konfigurisan. Trebalo bi da isključuje:

- `.env` fajl (ne sme biti commit-ovan!)
- `vendor/` folder
- `node_modules/` folder
- `storage/` folder (osim .gitignore fajlova)
- Cache fajlove

### 1.2 Proverite da li postoji .env.example

Uverite se da postoji `.env.example` fajl sa primerom konfiguracije (bez stvarnih API ključeva).

## Korak 2: Inicijalizacija Git Repozitorijuma

### 2.1 Ako projekat još nije Git repozitorijum

Otvorite terminal u root folderu projekta i pokrenite:

```bash
# Inicijalizuj Git repozitorijum
git init

# Dodaj sve fajlove (Git će automatski poštovati .gitignore)
git add .

# Napravi prvi commit
git commit -m "Initial commit: Formula 1 Fantasy Laravel application"
```

### 2.2 Ako projekat već ima Git repozitorijum

Proverite status:

```bash
git status
```

Ako ima necommit-ovanih promena:

```bash
git add .
git commit -m "Update: Final version before GitHub push"
```

## Korak 3: Kreiranje GitHub Repozitorijuma

### 3.1 Preko GitHub Web Interfejsa

1. Idite na [GitHub](https://github.com) i prijavite se
2. Kliknite na **"+"** u gornjem desnom uglu i izaberite **"New repository"**
3. Unesite:
   - **Repository name**: `fantasyf1` (ili neki drugi naziv)
   - **Description**: "Formula 1 Fantasy Web Application - Laravel"
   - **Visibility**: Public ili Private (prema vašim potrebama)
   - **NE** dodavajte README, .gitignore, ili licencu (već imamo)
4. Kliknite **"Create repository"**

### 3.2 Preko GitHub CLI (opciono)

Ako imate GitHub CLI instaliran:

```bash
gh repo create fantasyf1 --public --description "Formula 1 Fantasy Web Application - Laravel"
```

## Korak 4: Povezivanje Lokalnog Repozitorijuma sa GitHub-om

### 4.1 Dodajte Remote

GitHub će vam pokazati komande nakon kreiranja repozitorijuma. Koristite HTTPS ili SSH:

**HTTPS (preporučeno za početnike):**

```bash
git remote add origin https://github.com/[VAŠE-KORISNIČKO-IME]/fantasyf1.git
```

**SSH (ako imate SSH key podešen):**

```bash
git remote add origin git@github.com:[VAŠE-KORISNIČKO-IME]/fantasyf1.git
```

### 4.2 Proverite Remote

```bash
git remote -v
```

Trebalo bi da vidite:

```
origin  https://github.com/[VAŠE-KORISNIČKO-IME]/fantasyf1.git (fetch)
origin  https://github.com/[VAŠE-KORISNIČKO-IME]/fantasyf1.git (push)
```

## Korak 5: Push na GitHub

### 5.1 Preimenujte glavnu granu u "main" (ako je potrebno)

```bash
git branch -M main
```

### 5.2 Push-ujte kod

```bash
git push -u origin main
```

Ako GitHub traži autentifikaciju:

- **HTTPS**: Unesite GitHub korisničko ime i Personal Access Token (ne lozinku!)
- **SSH**: Ako imate SSH key podešen, neće tražiti autentifikaciju

### 5.3 Kako dobiti Personal Access Token (za HTTPS)

1. Idite na GitHub Settings > Developer settings > Personal access tokens > Tokens (classic)
2. Kliknite "Generate new token (classic)"
3. Dajte mu naziv (npr. "fantasyf1-project")
4. Izaberite scope: `repo` (full control of private repositories)
5. Kliknite "Generate token"
6. **Kopirajte token** (nećete ga moći videti ponovo!)
7. Koristite token umesto lozinke kada Git traži autentifikaciju

## Korak 6: Verifikacija

### 6.1 Proverite na GitHub-u

Idite na vaš GitHub repozitorijum i proverite da li su svi fajlovi upload-ovani.

### 6.2 Proverite da .env NIJE commit-ovan

**VAŽNO**: Proverite da `.env` fajl **NIJE** na GitHub-u. Ako jeste:

1. Obrišite ga sa GitHub-a (preko web interfejsa)
2. Dodajte ga u `.gitignore` ako nije već tamo
3. Obrišite ga iz Git istorije (opciono, ali preporučeno):

```bash
git rm --cached .env
git commit -m "Remove .env from repository"
git push
```

## Korak 7: Dodatne Konfiguracije (Opciono)

### 7.1 Dodajte GitHub Topics

Na GitHub repozitorijumu, kliknite na "Add topics" i dodajte:
- `laravel`
- `php`
- `fantasy-sports`
- `formula1`
- `web-application`

### 7.2 Dodajte GitHub Actions (Opciono)

Možete dodati CI/CD workflow za automatsko testiranje:

Kreirajte `.github/workflows/tests.yml`:

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          
      - name: Install Dependencies
        run: |
          composer install
          npm install
          
      - name: Run Tests
        run: php artisan test
```

## Korak 8: Kloniranje Projekta (za druge korisnike)

Nakon što je projekat na GitHub-u, drugi korisnici mogu klonirati:

```bash
git clone https://github.com/[VAŠE-KORISNIČKO-IME]/fantasyf1.git
cd fantasyf1
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

## Troubleshooting

### Problem: "remote origin already exists"

Rešenje:

```bash
git remote remove origin
git remote add origin https://github.com/[VAŠE-KORISNIČKO-IME]/fantasyf1.git
```

### Problem: "Authentication failed"

Rešenje:
- Proverite da li koristite Personal Access Token umesto lozinke
- Proverite da li je token validan i ima `repo` scope

### Problem: "Permission denied"

Rešenje:
- Proverite da li imate prava na repozitorijum
- Proverite da li je repozitorijum public ili imate pristup ako je private

### Problem: ".env je commit-ovan"

Rešenje:

```bash
# Ukloni .env iz Git tracking-a
git rm --cached .env

# Dodaj commit
git commit -m "Remove .env from repository"

# Push
git push

# Proveri .gitignore
echo ".env" >> .gitignore
git add .gitignore
git commit -m "Add .env to .gitignore"
git push
```

## Checklist Pre Push-a

- [ ] `.env` fajl je u `.gitignore`
- [ ] `.env.example` postoji sa primerom konfiguracije
- [ ] `vendor/` i `node_modules/` su u `.gitignore`
- [ ] README.md je ažuriran
- [ ] Nema osetljivih podataka u kodu (API ključevi, lozinke)
- [ ] Svi fajlovi su commit-ovani
- [ ] Git status je čist (`git status`)

---

**Napomena**: Uvek proverite da `.env` fajl nije commit-ovan pre push-a na GitHub!
