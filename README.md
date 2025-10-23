#  Laravel Realaus laiko WebSocket demonstracija

Šis projektas parodo, kaip Laravel panaudoti **realaus laiko pranešimams (WebSocket)** su:
- **Laravel WebSockets** (BeyondCode)
- **Laravel Echo**
- **pusher-js**
- **Blade vaizdais:** `test.blade.php` ir `sendmsg.blade.php`

---

##  Projekto paskirtis

Projektas demonstruoja, kaip veikia **realaus laiko pranešimų sistema**:
- `sendmsg.blade.php` – leidžia siųsti žinutę per API (POST /send)
- `test.blade.php` – rodo gautas žinutes **realiu laiku**, be perkrovimo

Visas srautas vyksta per Laravel WebSockets serverį (vietinį, be Pusher prenumeratos).

---

##  Sistemos reikalavimai

- PHP 8.1+  
- Composer  
- Node.js + NPM  
- MySQL arba SQLite (pasirinktinai)  
- Laravel 10+  

---

##  Projekto paleidimo žingsniai

### 1️⃣ Klonuokite projektą

git clone https://github.com/tavo-vartotojas/laravel-websocket-demo.git
cd laravel-websocket-demo
`

### 2️⃣ Įdiekite priklausomybes


composer install
npm install


### 3️⃣ Sukurkite `.env` failą iš kopijos


cp .env pavyzdys .env


### 4️⃣ Sugeneruokite aplikacijos raktą


php artisan key:generate


### 5️⃣ Nustatykite duomenų bazę

Jei nenaudojate DB, galite palikti SQLite arba komentuoti migracijas.


php artisan migrate

### `.env` nustatymai
Kitu atveju suvesti mysql ir reikalingus parametrus 

---

## 🧩 WebSocket konfigūracija

### `.env` nustatymai

Įsitikinkite, kad `.env` faile yra:

env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=local
PUSHER_APP_KEY=local
PUSHER_APP_SECRET=local
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1


---

## 🧠 Paleidimo serveriai

Projekte veikia **trys skirtingi serveriai**:

| Serveris     | Komanda                        | Paskirtis                                               |
| ------------ | ------------------------------ | ------------------------------------------------------- |
| Laravel HTTP | `php artisan serve`            | API maršrutai (pvz. POST /send, GET /test)              |
| WebSocket    | `php artisan websockets:serve` | Realaus laiko ryšys (portas 6001)                       |
| Vite / NPM   | `npm run dev`                  | JavaScript, Echo, Live atnaujinimai (Vite dev serveris) |

> 💡 Visi trys turi būti paleisti vienu metu, pvz. trimis terminalais.

---

## 🧩 Tipinis paleidimas (localhost'e)


# Terminalas 1
php artisan serve

# Terminalas 2
php artisan websockets:serve

# Terminalas 3
npm run dev


Tada atidarykite naršyklėje:

* [http://127.0.0.1:8000/sendmsg](http://127.0.0.1:8000/sendmsg) → siųsti žinutes
* [http://127.0.0.1:8000/test](http://127.0.0.1:8000/test) → matyti žinutes realiu laiku

---

## 📡 Kaip  veikia

1. `sendmsg.blade.php` išsiunčia žinutę į `/send`
2. Laravel iškviečia `MessageSent` event’ą (`broadcast`)
3. Laravel WebSockets serveris perduoda event’ą visiems prisijungusiems klientams
4. `test.blade.php` gauna pranešimą per Laravel Echo (WebSocket ryšiu)
5. Žinutė atsiranda test ekrane **be puslapio perkrovimo**

---

## 🔍 Naudojami pagrindiniai failai

| Failas                              | Paskirtis                                 |
| ----------------------------------- | ----------------------------------------- |
| `routes/web.php`                    | Maršrutai /send ir /test                  |
| `app/Events/MessageSent.php`        | Laravel event’as, siunčiamas broadcast’ui |
| `resources/views/test.blade.php`    | Klientas, gaunantis žinutes realiu laiku  |
| `resources/views/sendmsg.blade.php` | Paprasta forma žinutės siuntimui          |
| `resources/js/bootstrap.js`         | Laravel Echo konfigūracija                |
| `vite.config.js`                    | Vite nustatymai frontend’ui               |

---

##  Papildomai 


* WebSockets veikia **tik kai `websockets:serve` paleistas**
* Galite stebėti prisijungimus naršyklėje: [http://127.0.0.1:8000/laravel-websockets](http://127.0.0.1:8000/laravel-websockets)

---

##  Naudotos technologijos

* Laravel 10
* Laravel WebSockets (BeyondCode)
* Laravel Echo
* pusher-js
* Vite + ES Modules

