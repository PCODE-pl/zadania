# INSTALACJA

Jeżeli nie masz jeszcze zainstalowanego Homebrew/Warden, możesz to zrobić poleceniami:

```bash
make install-homebrew
make install-warden
```

Jeżeli masz już zainstalowane Homebrew/Warden, możesz przejść do instalacji Magento, Sample Data i modułów zadań:

Skopiuj plik `auth.json.sample` do `auth.json` i uzupełnij go swoimi danymi dostępowymi do repozytorium Magento. Następnie uruchom polecenie:

```bash
make build
```

Magento zostanie zainstalowane w trybie developerskim, moduły zadań zostaną zainstalowane automatycznie.

Strona będzie dostępna pod adresem `https://zadania.test`.

Admin Magento będzie dostępny pod adresem `https://zadania.test/admin`

Domyślne dane logowania do panelu admina Magento:

- user: `admin`
- password: `admin123`
