# Cyber Blog — Progetto Finale Cybersecurity

Cyber Blog è un'applicazione Laravel sviluppata come progetto finale per il percorso Aulab, con l'obiettivo di analizzare, sfruttare e mitigare vulnerabilità tipiche di una web application.

Il progetto parte da una piattaforma blog con gestione utenti, articoli, ruoli e funzionalità accessorie. Su questa base sono state implementate mitigazioni di sicurezza relative a rate limiting, CSRF, logging, SSRF, Stored XSS, Mass Assignment, clickjacking, SQL Injection, scansione OWASP ZAP e autorizzazioni tramite Laravel Policies.

---

## Obiettivo del progetto

L'obiettivo non è soltanto sviluppare nuove funzionalità, ma dimostrare un flusso completo di lavoro orientato alla sicurezza:

```text
analisi della vulnerabilità
riproduzione controllata del problema
implementazione della mitigazione
retest dopo la correzione
documentazione tecnica con screenshot
commit Git ordinati
```

Il progetto è pensato come applicazione didattica e portfolio per mostrare competenze da junior full-stack developer con focus sulla sicurezza applicativa.

---

## Tecnologie utilizzate

```text
PHP 8.3
Laravel
Laravel Fortify
Laravel Scout
TNTSearch
Livewire
Blade
Bootstrap
MySQL
Composer
NPM / Vite
OWASP ZAP
Git / GitHub
```

---

## Funzionalità principali

L'applicazione include:

```text
registrazione e login utenti
gestione ruoli user / writer / revisor / admin
creazione, modifica e cancellazione articoli
sistema di revisione articoli
ricerca articoli
categorie e tag
upload immagini
dashboard dedicate per writer, revisor e admin
profilo utente
integrazione controllata con servizi esterni
documentazione tecnica delle mitigazioni
```

---

## Setup locale

### 1. Clonare il repository

```bash
git clone https://github.com/CifDaniel96/progetto-finale-cyber-daniel-ciferni.git
cd progetto-finale-cyber-daniel-ciferni
```

### 2. Installare le dipendenze PHP

```bash
composer install
```

### 3. Installare le dipendenze frontend

```bash
npm install
```

### 4. Creare il file `.env`

```bash
cp .env.example .env
```

Configurare poi il database locale nel file `.env`.

Esempio:

```env
DB_DATABASE=final_project_cyber_blog
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generare la chiave applicativa

```bash
php artisan key:generate
```

### 6. Eseguire migrations e seeders

```bash
php artisan migrate --seed
```

### 7. Creare il link simbolico per lo storage

```bash
php artisan storage:link
```

### 8. Avviare il server Laravel

```bash
php artisan serve --host=cyber.blog --port=8000
```

### 9. Avviare Vite

In un secondo terminale:

```bash
npm run dev
```

---

## Configurazione hosts locale

Per utilizzare i domini locali previsti dal progetto, aggiungere al file hosts del sistema:

```text
127.0.0.1 cyber.blog
127.0.0.1 internal.admin
```

Su Windows il file si trova generalmente in:

```text
C:\Windows\System32\drivers\etc\hosts
```

---

## Utenti di test

Tutti gli utenti creati dal seeder utilizzano la password:

```text
password
```

| Ruolo | Email |
|---|---|
| User | user@aulab.it |
| Writer | writer@aulab.it |
| Revisor | revisor@aulab.it |
| Admin | admin@aulab.it |
| Super Admin | super.admin@aulab.it |
| Attacker | kvrs@gmail.com |

---

## Challenge completate

### Challenge 1 — Rate Limiting

È stato implementato un rate limiter dedicato alla ricerca articoli per ridurre il rischio di abuso della rotta pubblica.

Documentazione:

[Challenge 1 — Rate Limiter](docs/challenge-1-rate-limiter.md)

---

### Challenge 2 — CSRF e operazioni critiche

Le operazioni critiche precedentemente esposte tramite richieste non sicure sono state convertite in form protetti da token CSRF e metodo HTTP appropriato.

Documentazione:

[Challenge 2 — CSRF](docs/challenge-2-csrf.md)

---

### Challenge 3 — Logging operazioni critiche

Sono stati aggiunti log applicativi per eventi sensibili come autenticazione, registrazione, logout, creazione/modifica/cancellazione articoli e gestione ruoli.

Documentazione:

[Challenge 3 — Logging](docs/challenge-3-logging.md)

---

### Challenge 4 — SSRF

La funzionalità che recupera dati esterni è stata analizzata e mitigata tramite validazione degli input, allowlist e controllo delle richieste verso servizi interni.

Documentazione:

[Challenge 4 — SSRF](docs/challenge-4-ssrf.md)

---

### Challenge 5 — Stored XSS

È stata mitigata una vulnerabilità Stored XSS sanitizzando il contenuto HTML degli articoli tramite un servizio dedicato basato su HTML Purifier.

Documentazione:

[Challenge 5 — Stored XSS](docs/challenge-5-stored-xss.md)

---

### Challenge 6 — Mass Assignment

È stata mitigata una vulnerabilità di Mass Assignment rimuovendo i campi di ruolo dal `$fillable` del model `User` e validando esplicitamente i dati aggiornabili dal profilo.

Documentazione:

[Challenge 6 — Mass Assignment](docs/challenge-6-mass-assignment.md)

---

## Bonus completati

### Bonus 1 — Login Rate Limiter

È stato migliorato il rate limiter del login con controllo su IP e combinazione account/IP.

Documentazione:

[Bonus 1 — Login Rate Limiter](docs/bonus-1-login-rate-limiter.md)

---

### Bonus 2 — Clickjacking

È stata aggiunta protezione anti-clickjacking tramite header HTTP dedicati:

```text
X-Frame-Options: SAMEORIGIN
Content-Security-Policy: frame-ancestors 'self'
```

Documentazione:

[Bonus 2 — Clickjacking](docs/bonus-2-clickjacking.md)

---

### Bonus 3 — Laravel Scout e SQL Injection

La ricerca articoli è stata analizzata rispetto a possibili tentativi di SQL Injection. Il flusso utilizza Laravel Scout e una micro-validazione dell'input pubblico.

Documentazione:

[Bonus 3 — Laravel Scout e SQL Injection](docs/bonus-3-scout-sql-injection.md)

---

### Bonus 4 — OWASP ZAP Scan

È stata eseguita una scansione dell'applicazione con OWASP ZAP. Alcuni header di sicurezza sono stati migliorati sulla base degli alert rilevati.

Documentazione:

[Bonus 4 — OWASP ZAP Scan](docs/bonus-4-owasp-zap-scan.md)

---

### Bonus 5 — Laravel Policies

La gestione dell'autorizzazione per modifica e cancellazione articoli è stata centralizzata tramite `ArticlePolicy`.

Documentazione:

[Bonus 5 — Laravel Policies](docs/bonus-5-laravel-policies.md)

---

## Principali mitigazioni implementate

```text
Rate limiting su rotte pubbliche sensibili
Protezione CSRF su operazioni critiche
Logging di eventi rilevanti
Validazione e allowlist per richieste esterne
Sanitizzazione HTML contro Stored XSS
Riduzione dei campi mass assignable
Header anti-clickjacking
Header X-Content-Type-Options
Rimozione header X-Powered-By
Validazione input ricerca
Autorizzazioni centralizzate tramite Policy
```

---

## Struttura documentazione

La documentazione tecnica è contenuta nella cartella:

```text
docs/
```

Ogni challenge e bonus contiene:

```text
analisi iniziale
scenario di test
mitigazione applicata
retest
screenshot
conclusione tecnica
```

Gli screenshot sono contenuti in:

```text
docs/images/
```

---

## Note di sicurezza

Il progetto è stato sviluppato in ambiente locale e ha finalità didattiche.

Le vulnerabilità sono state testate esclusivamente sull'applicazione del progetto, in un contesto controllato e autorizzato.

Eventuali chiavi API o credenziali reali non devono essere versionate nel repository. Il file `.env` non deve essere caricato su GitHub.

---

## Stato del progetto

Il progetto include tutte le challenge principali e i bonus implementati, documentati e versionati tramite Git.

Il repository mostra un flusso di lavoro progressivo basato su:

```text
commit per singola mitigazione
documentazione dedicata
screenshot di verifica
controlli sintattici
retest funzionali
```

---

## Autore

Progetto realizzato da Daniel Ciferni come progetto finale del percorso Aulab - specializzazione in Cybersecurity On Demand