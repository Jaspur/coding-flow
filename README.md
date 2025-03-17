# CodingFlow

🚀 **CodingFlow** is een Laravel package dat automatisch repositories, services, DTO’s, API resources en tests genereert op basis van Laravel Blueprint.  
Hierdoor kun je sneller een **gestructureerde en schaalbare codebase** opzetten met **best practices**.  

---

## 📌 **Installatie**

```sh
composer require jaspur/coding-flow --dev
```

Na installatie kun je de configuratie publiceren met:

```sh
php artisan vendor:publish --tag=codingflow-config
```

---

## ⚡ **Gebruik**

Je kunt de complete projectstructuur genereren met één command:  

```sh
php artisan codingflow:generate-structure
```

Individuele componenten genereren:

```sh
php artisan codingflow:generate-repositories
php artisan codingflow:generate-services
php artisan codingflow:generate-dtos
php artisan codingflow:generate-api-resources
php artisan codingflow:generate-feature-tests
php artisan codingflow:generate-observers
```

Wil je dat **CodingFlow** automatisch bijhoudt welke modellen en controllers gegenereerd moeten worden?  
Dat kan via Laravel Blueprint! Zorg dat je een `blueprint.yaml` hebt en voer uit:  

```sh
php artisan blueprint:build && php artisan codingflow:generate
```

---

## ⚙ **Configuratie**

Het `config/codingflow.php` bestand bevat alle instellingen voor welke componenten worden gegenereerd en waar de bestanden worden opgeslagen.  

Voorbeeldconfiguratie:

```php
return [
    'overwrite_existing_files' => false,

    'generators' => [
        'repositories'   => true,
        'services'       => true,
        'dtos'           => true,
        'api_resources'  => true,
        'feature_tests'  => true,
        'observers'      => true,
    ],

    'paths' => [
        'repositories'   => app_path('Repositories'),
        'services'       => app_path('Services'),
        'dtos'           => app_path('DTOs'),
        'api_resources'  => app_path('Http/Resources'),
        'feature_tests'  => base_path('tests/Feature'),
        'observers'      => app_path('Observers'),
    ],

    'watch_blueprint' => true,

    'code_quality' => [
        'phpstan' => true,
        'pint'    => true,
        'rector'  => true,
    ],
];
```

---

## ✅ **Wat genereert CodingFlow?**

| 🏗 **Component**   | 📄 **Bestandsstructuur** |
|------------------|------------------|
| **Repositories** | `app/Repositories/PostRepository.php` |
| **Services** | `app/Services/PostService.php` |
| **DTO’s** | `app/DTOs/PostDTO.php` |
| **API Resources** | `app/Http/Resources/PostResource.php` |
| **Feature Tests** | `tests/Feature/PostTest.php` |
| **Observers** | `app/Observers/PostObserver.php` |

---

## 🛠 **Code Kwaliteit & Standaarden**
CodingFlow ondersteunt automatisch:
✅ **PHPStan (Level 9) voor statische analyse**  
✅ **Laravel Pint voor code formatting**  
✅ **Rector voor automatische code verbeteringen**  

Voer deze checks handmatig uit:

```sh
./prerelease.sh
```

---

## 🎯 **Roadmap & Toekomstige Features**
✅ Ondersteuning voor Laravel 10 & 11  
✅ Automatische model-detectie via Eloquent  
⏳ Integratie met Laravel Nova voor resource controllers  
⏳ Extra validaties in DTO's  

🔥 **Wil je bijdragen? Fork de repo en stuur een PR!**  

---

## 📜 **Licentie**
CodingFlow wordt uitgebracht onder de **MIT License**.  
