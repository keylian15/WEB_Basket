<p align="center">
	<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KICAgIDxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB2aWV3Qm94PSIwIDAgODAwIDIwMCI+CiAgICAgICAgPGRlZnM+CiAgICAgICAgICAgIDxsaW5lYXJHcmFkaWVudCBpZD0iYmctZ3JhZGllbnQiIHgxPSIwJSIgeTE9IjAlIiB4Mj0iMTAwJSIgeTI9IjEwMCUiPgogICAgICAgICAgICAgICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3R5bGU9InN0b3AtY29sb3I6IzQxNThEMDtzdG9wLW9wYWNpdHk6MSIgLz4KICAgICAgICAgICAgICAgIDxzdG9wIG9mZnNldD0iNTAlIiBzdHlsZT0ic3RvcC1jb2xvcjojQzg1MEMwO3N0b3Atb3BhY2l0eToxIiAvPgogICAgICAgICAgICAgICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdHlsZT0ic3RvcC1jb2xvcjojRkZDQzcwO3N0b3Atb3BhY2l0eToxIiAvPgogICAgICAgICAgICA8L2xpbmVhckdyYWRpZW50PgogICAgICAgICAgICA8ZmlsdGVyIGlkPSJzaGFkb3ciPgogICAgICAgICAgICAgICAgPGZlRHJvcFNoYWRvdyBkeD0iMCIgZHk9IjQiIHN0ZERldmlhdGlvbj0iNCIgZmxvb2Qtb3BhY2l0eT0iMC4yNSIgLz4KICAgICAgICAgICAgPC9maWx0ZXI+CiAgICAgICAgPC9kZWZzPgogICAgICAgIDxyZWN0IHdpZHRoPSI4MDAiIGhlaWdodD0iMjAwIiBmaWxsPSJ1cmwoI2JnLWdyYWRpZW50KSIgcng9IjE1IiByeT0iMTUiLz4KICAgICAgICA8dGV4dCB4PSI0MDAiIHk9IjEwMCIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjQ4IgogICAgICAgIGZvbnQtd2VpZ2h0PSJib2xkIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkb21pbmFudC1iYXNlbGluZT0ibWlkZGxlIgogICAgICAgIGZpbGw9IiNGRkZGRkYiIGZpbHRlcj0idXJsKCNzaGFkb3cpIj5XRUJfQkFTS0VUPC90ZXh0PgogICAgPC9zdmc+" alt="web_basket-banner" width="800">
</p>
<p align="center">
	<img src="https://img.shields.io/github/license/keylian15/WEB_Basket?style=flat&logo=opensourceinitiative&logoColor=white&color=00fffb" alt="license">
	<img src="https://img.shields.io/github/last-commit/keylian15/WEB_Basket?style=flat&logo=git&logoColor=white&color=00fffb" alt="last-commit">
	<img src="https://img.shields.io/github/languages/top/keylian15/WEB_Basket?style=flat&color=00fffb" alt="repo-top-language">
	<img src="https://img.shields.io/github/languages/count/keylian15/WEB_Basket?style=flat&color=00fffb" alt="repo-language-count">
</p>
<p align="center">Built with the tools and technologies:</p>
<p align="center">
	<img src="https://img.shields.io/badge/Composer-885630.svg?style=flat&logo=Composer&logoColor=white" alt="Composer">
	<img src="https://img.shields.io/badge/JavaScript-F7DF1E.svg?style=flat&logo=JavaScript&logoColor=black" alt="JavaScript">
	<img src="https://img.shields.io/badge/PHP-777BB4.svg?style=flat&logo=PHP&logoColor=white" alt="PHP">
</p>
<br>

## Table of Contents

- [ Overview](#-overview)
- [ Features](#-features)
- [ Project Structure](#-project-structure)
- [ Getting Started](#-getting-started)
  - [ Prerequisites](#-prerequisites)
  - [ Installation](#-installation)
  - [ Usage](#-usage)
  - [ Testing](#-testing)
- [ Contributing](#-contributing)
- [ Acknowledgments](#-acknowledgments)

---

## Overview

The web version of `api_basket` is a front-end interface built to interact with the basketball API. It allows users to explore basketball data visually, including teams, players, past matches, and predictions based on game history. The main goal of the web app is to make the data provided by the API accessible and user-friendly, with interactive views and filters.

---

## Features

- **Team & Player Explorer**  
  Browse all basketball teams and view detailed rosters and player stats.

- **Match History Viewer**  
  Access historical match data, including scores, dates, and performance highlights.

- **Prediction Interface**  
  View predicted match outcomes based on past data and trends from the API.

- **Interactive & Responsive UI**  
  Designed for both desktop and mobile users, with intuitive navigation and clean visuals.

---

## Project Structure

```sh
└── WEB_Basket/
    ├── check_login.php
    ├── class
    │   └── myAuthClass.php
    ├── config
    │   └── database.php
    ├── controllers
    │   ├── api
    │   │   └── index.php
    │   ├── classement
    │   │   └── index.php
    │   ├── equipes
    │   │   ├── add.php
    │   │   ├── compare.php
    │   │   ├── delete.php
    │   │   ├── index.php
    │   │   └── view.php
    │   ├── index.php
    │   ├── joueurs
    │   │   ├── add.php
    │   │   ├── compare.php
    │   │   ├── delete.php
    │   │   ├── index.php
    │   │   └── view.php
    │   ├── matchs
    │   │   ├── add.php
    │   │   ├── delete.php
    │   │   ├── index.php
    │   │   └── view.php
    │   └── prediction
    │       └── index.php
    ├── css
    │   └── styles.css
    ├── delog.php
    ├── inc
    │   ├── content.php
    │   ├── footer.php
    │   ├── head.php
    │   ├── left.php
    │   ├── list.php
    │   ├── notfound.php
    │   └── top.php
    ├── index.php
    ├── js
    │   └── scripts.js
    ├── lib
    │   ├── mypdo.php
    │   ├── myproject.lib.php
    │   └── security.lib.php
    ├── login.php
    ├── main.inc.php
    ├── mld_db.txt
    ├── public
    │   ├── css
    │   │   └── styles.css
    │   └── js
    │       └── main.js
    ├── vendor
    │   ├── autoload.php
    │   ├── composer
    │   │   ├── ClassLoader.php
    │   │   ├── InstalledVersions.php
    │   │   ├── LICENSE
    │   │   ├── autoload_classmap.php
    │   │   ├── autoload_files.php
    │   │   ├── autoload_namespaces.php
    │   │   ├── autoload_psr4.php
    │   │   ├── autoload_real.php
    │   │   ├── autoload_static.php
    │   │   ├── installed.json
    │   │   ├── installed.php
    │   │   └── platform_check.php
    │   ├── graham-campbell
    │   │   └── result-type
    │   │       ├── LICENSE
    │   │       ├── composer.json
    │   │       └── src
    │   │           ├── Error.php
    │   │           ├── Result.php
    │   │           └── Success.php
    │   ├── phpoption
    │   │   └── phpoption
    │   │       ├── LICENSE
    │   │       ├── composer.json
    │   │       └── src
    │   │           └── PhpOption
    │   ├── symfony
    │   │   ├── polyfill-ctype
    │   │   │   ├── Ctype.php
    │   │   │   ├── LICENSE
    │   │   │   ├── README.md
    │   │   │   ├── bootstrap.php
    │   │   │   ├── bootstrap80.php
    │   │   │   └── composer.json
    │   │   ├── polyfill-mbstring
    │   │   │   ├── LICENSE
    │   │   │   ├── Mbstring.php
    │   │   │   ├── README.md
    │   │   │   ├── Resources
    │   │   │   │   └── unidata
    │   │   │   ├── bootstrap.php
    │   │   │   ├── bootstrap80.php
    │   │   │   └── composer.json
    │   │   └── polyfill-php80
    │   │       ├── LICENSE
    │   │       ├── Php80.php
    │   │       ├── PhpToken.php
    │   │       ├── README.md
    │   │       ├── Resources
    │   │       │   └── stubs
    │   │       ├── bootstrap.php
    │   │       └── composer.json
    │   └── vlucas
    │       └── phpdotenv
    │           ├── LICENSE
    │           ├── composer.json
    │           └── src
    │               ├── Dotenv.php
    │               ├── Exception
    │               ├── Loader
    │               ├── Parser
    │               ├── Repository
    │               ├── Store
    │               ├── Util
    │               └── Validator.php
    └── views
        ├── api
        │   └── index.php
        ├── classement
        │   └── index.php
        ├── equipes
        │   ├── add.php
        │   ├── compare.php
        │   ├── delete.php
        │   ├── index.php
        │   └── view.php
        ├── index.php
        ├── joueurs
        │   ├── add.php
        │   ├── compare.php
        │   ├── delete.php
        │   ├── index.php
        │   └── view.php
        ├── matchs
        │   ├── add.php
        │   ├── delete.php
        │   ├── index.php
        │   └── view.php
        └── prediction
            └── index.php
```

---

## Getting Started

### Prerequisites

Before getting started with WEB_Basket, ensure your runtime environment meets the following requirements:

- **Programming Language:** PHP
- **Package Manager:** Composer

### Installation

Install WEB_Basket using one of the following methods:

**Build from source:**

1. Clone the WEB_Basket repository:

```sh
❯ git clone https://github.com/keylian15/WEB_Basket
```

2. Navigate to the project directory:

```sh
❯ cd WEB_Basket
```

3. Install the project dependencies:

**Using `composer`** &nbsp; [<img align="center" src="https://img.shields.io/badge/PHP-777BB4.svg?style={badge_style}&logo=php&logoColor=white" />](https://www.php.net/)

```sh
❯ composer install
```

### Usage

Run WEB_Basket using the following command:
**Using `composer`** &nbsp; [<img align="center" src="https://img.shields.io/badge/PHP-777BB4.svg?style={badge_style}&logo=php&logoColor=white" />](https://www.php.net/)

```sh
❯ php {entrypoint}
```

### Testing

Run the test suite using the following command:
**Using `composer`** &nbsp; [<img align="center" src="https://img.shields.io/badge/PHP-777BB4.svg?style={badge_style}&logo=php&logoColor=white" />](https://www.php.net/)

```sh
❯ vendor/bin/phpunit
```

## Contributing

- **💬 [Join the Discussions](https://github.com/keylian15/WEB_Basket/discussions)**: Share your insights, provide feedback, or ask questions.
- **🐛 [Report Issues](https://github.com/keylian15/WEB_Basket/issues)**: Submit bugs found or log feature requests for the `WEB_Basket` project.

<details closed>
<summary>Contributing Guidelines</summary>

1. **Fork the Repository**: Start by forking the project repository to your github account.
2. **Clone Locally**: Clone the forked repository to your local machine using a git client.
   ```sh
   git clone https://github.com/keylian15/WEB_Basket
   ```
3. **Create a New Branch**: Always work on a new branch, giving it a descriptive name.
   ```sh
   git checkout -b new-feature-x
   ```
4. **Make Your Changes**: Develop and test your changes locally.
5. **Commit Your Changes**: Commit with a clear message describing your updates.
   ```sh
   git commit -m 'Implemented new feature x.'
   ```
6. **Push to github**: Push the changes to your forked repository.
   ```sh
   git push origin new-feature-x
   ```
7. **Submit a Pull Request**: Create a PR against the original project repository. Clearly describe the changes and their motivations.
8. **Review**: Once your PR is reviewed and approved, it will be merged into the main branch. Congratulations on your contribution!
</details>

<details closed>
<summary>Contributor Graph</summary>
<br>
<p align="left">
   <a href="https://github.com{/keylian15/WEB_Basket/}graphs/contributors">
      <img src="https://contrib.rocks/image?repo=keylian15/WEB_Basket">
   </a>
</p>
</details>

---

## Acknowledgments

<a href="https://github.com{/keylian15/WEB_Basket/}graphs/contributors">
    <img src="https://contrib.rocks/image?repo=keylian15/WEB_Basket">
</a>

---

_This documentation was generated using [readme-ai](https://readme-ai.streamlit.app)._
