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
  - [ Project Index](#-project-index)
- [ Getting Started](#-getting-started)
  - [ Prerequisites](#-prerequisites)
  - [ Installation](#-installation)
  - [ Usage](#-usage)
  - [ Testing](#-testing)
- [ Project Roadmap](#-project-roadmap)
- [ Contributing](#-contributing)
- [ License](#-license)
- [ Acknowledgments](#-acknowledgments)

---

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

### Project Index

<details open>
	<summary><b><code>WEB_BASKET/</code></b></summary>
	<details> <!-- __root__ Submodule -->
		<summary><b>__root__</b></summary>
		<blockquote>
			<table>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/delog.php'>delog.php</a></b></td>
			</tr>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/index.php'>index.php</a></b></td>
			</tr>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/mld_db.txt'>mld_db.txt</a></b></td>
			</tr>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/check_login.php'>check_login.php</a></b></td>
			</tr>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/main.inc.php'>main.inc.php</a></b></td>
			</tr>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/login.php'>login.php</a></b></td>
			</tr>
			</table>
		</blockquote>
	</details>
	<details> <!-- inc Submodule -->
		<summary><b>inc</b></summary>
		<blockquote>
			<table>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/inc/notfound.php'>notfound.php</a></b></td>
			</tr>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/inc/footer.php'>footer.php</a></b></td>
			</tr>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/inc/content.php'>content.php</a></b></td>
			</tr>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/inc/list.php'>list.php</a></b></td>
			</tr>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/inc/top.php'>top.php</a></b></td>
			</tr>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/inc/head.php'>head.php</a></b></td>
			</tr>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/inc/left.php'>left.php</a></b></td>
			</tr>
			</table>
		</blockquote>
	</details>
	<details> <!-- css Submodule -->
		<summary><b>css</b></summary>
		<blockquote>
			<table>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/css/styles.css'>styles.css</a></b></td>
			</tr>
			</table>
		</blockquote>
	</details>
	<details> <!-- lib Submodule -->
		<summary><b>lib</b></summary>
		<blockquote>
			<table>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/lib/security.lib.php'>security.lib.php</a></b></td>
			</tr>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/lib/mypdo.php'>mypdo.php</a></b></td>
			</tr>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/lib/myproject.lib.php'>myproject.lib.php</a></b></td>
			</tr>
			</table>
		</blockquote>
	</details>
	<details> <!-- js Submodule -->
		<summary><b>js</b></summary>
		<blockquote>
			<table>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/js/scripts.js'>scripts.js</a></b></td>
			</tr>
			</table>
		</blockquote>
	</details>
	<details> <!-- config Submodule -->
		<summary><b>config</b></summary>
		<blockquote>
			<table>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/config/database.php'>database.php</a></b></td>
			</tr>
			</table>
		</blockquote>
	</details>
	<details> <!-- controllers Submodule -->
		<summary><b>controllers</b></summary>
		<blockquote>
			<table>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/index.php'>index.php</a></b></td>
			</tr>
			</table>
			<details>
				<summary><b>equipes</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/equipes/add.php'>add.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/equipes/index.php'>index.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/equipes/delete.php'>delete.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/equipes/view.php'>view.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/equipes/compare.php'>compare.php</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
			<details>
				<summary><b>matchs</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/matchs/add.php'>add.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/matchs/index.php'>index.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/matchs/delete.php'>delete.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/matchs/view.php'>view.php</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
			<details>
				<summary><b>prediction</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/prediction/index.php'>index.php</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
			<details>
				<summary><b>joueurs</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/joueurs/add.php'>add.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/joueurs/index.php'>index.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/joueurs/delete.php'>delete.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/joueurs/view.php'>view.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/joueurs/compare.php'>compare.php</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
			<details>
				<summary><b>api</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/api/index.php'>index.php</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
			<details>
				<summary><b>classement</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/controllers/classement/index.php'>index.php</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
		</blockquote>
	</details>
	<details> <!-- vendor Submodule -->
		<summary><b>vendor</b></summary>
		<blockquote>
			<table>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/autoload.php'>autoload.php</a></b></td>
			</tr>
			</table>
			<details>
				<summary><b>vlucas</b></summary>
				<blockquote>
					<details>
						<summary><b>phpdotenv</b></summary>
						<blockquote>
							<table>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/composer.json'>composer.json</a></b></td>
							</tr>
							</table>
							<details>
								<summary><b>src</b></summary>
								<blockquote>
									<table>
									<tr>
										<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Dotenv.php'>Dotenv.php</a></b></td>
									</tr>
									<tr>
										<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Validator.php'>Validator.php</a></b></td>
									</tr>
									</table>
									<details>
										<summary><b>Loader</b></summary>
										<blockquote>
											<table>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Loader/Loader.php'>Loader.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Loader/LoaderInterface.php'>LoaderInterface.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Loader/Resolver.php'>Resolver.php</a></b></td>
											</tr>
											</table>
										</blockquote>
									</details>
									<details>
										<summary><b>Util</b></summary>
										<blockquote>
											<table>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Util/Str.php'>Str.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Util/Regex.php'>Regex.php</a></b></td>
											</tr>
											</table>
										</blockquote>
									</details>
									<details>
										<summary><b>Parser</b></summary>
										<blockquote>
											<table>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Parser/Parser.php'>Parser.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Parser/Lexer.php'>Lexer.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Parser/Lines.php'>Lines.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Parser/Entry.php'>Entry.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Parser/Value.php'>Value.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Parser/ParserInterface.php'>ParserInterface.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Parser/EntryParser.php'>EntryParser.php</a></b></td>
											</tr>
											</table>
										</blockquote>
									</details>
									<details>
										<summary><b>Repository</b></summary>
										<blockquote>
											<table>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/RepositoryBuilder.php'>RepositoryBuilder.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/RepositoryInterface.php'>RepositoryInterface.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/AdapterRepository.php'>AdapterRepository.php</a></b></td>
											</tr>
											</table>
											<details>
												<summary><b>Adapter</b></summary>
												<blockquote>
													<table>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/Adapter/ImmutableWriter.php'>ImmutableWriter.php</a></b></td>
													</tr>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/Adapter/MultiReader.php'>MultiReader.php</a></b></td>
													</tr>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/Adapter/PutenvAdapter.php'>PutenvAdapter.php</a></b></td>
													</tr>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/Adapter/EnvConstAdapter.php'>EnvConstAdapter.php</a></b></td>
													</tr>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/Adapter/AdapterInterface.php'>AdapterInterface.php</a></b></td>
													</tr>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/Adapter/ApacheAdapter.php'>ApacheAdapter.php</a></b></td>
													</tr>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/Adapter/ServerConstAdapter.php'>ServerConstAdapter.php</a></b></td>
													</tr>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/Adapter/ReaderInterface.php'>ReaderInterface.php</a></b></td>
													</tr>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/Adapter/GuardedWriter.php'>GuardedWriter.php</a></b></td>
													</tr>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/Adapter/ArrayAdapter.php'>ArrayAdapter.php</a></b></td>
													</tr>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/Adapter/WriterInterface.php'>WriterInterface.php</a></b></td>
													</tr>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/Adapter/MultiWriter.php'>MultiWriter.php</a></b></td>
													</tr>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Repository/Adapter/ReplacingWriter.php'>ReplacingWriter.php</a></b></td>
													</tr>
													</table>
												</blockquote>
											</details>
										</blockquote>
									</details>
									<details>
										<summary><b>Exception</b></summary>
										<blockquote>
											<table>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Exception/InvalidFileException.php'>InvalidFileException.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Exception/InvalidEncodingException.php'>InvalidEncodingException.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Exception/ValidationException.php'>ValidationException.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Exception/InvalidPathException.php'>InvalidPathException.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Exception/ExceptionInterface.php'>ExceptionInterface.php</a></b></td>
											</tr>
											</table>
										</blockquote>
									</details>
									<details>
										<summary><b>Store</b></summary>
										<blockquote>
											<table>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Store/StoreBuilder.php'>StoreBuilder.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Store/FileStore.php'>FileStore.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Store/StoreInterface.php'>StoreInterface.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Store/StringStore.php'>StringStore.php</a></b></td>
											</tr>
											</table>
											<details>
												<summary><b>File</b></summary>
												<blockquote>
													<table>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Store/File/Reader.php'>Reader.php</a></b></td>
													</tr>
													<tr>
														<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/vlucas/phpdotenv/src/Store/File/Paths.php'>Paths.php</a></b></td>
													</tr>
													</table>
												</blockquote>
											</details>
										</blockquote>
									</details>
								</blockquote>
							</details>
						</blockquote>
					</details>
				</blockquote>
			</details>
			<details>
				<summary><b>composer</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/composer/autoload_namespaces.php'>autoload_namespaces.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/composer/InstalledVersions.php'>InstalledVersions.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/composer/installed.php'>installed.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/composer/autoload_static.php'>autoload_static.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/composer/autoload_files.php'>autoload_files.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/composer/ClassLoader.php'>ClassLoader.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/composer/autoload_psr4.php'>autoload_psr4.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/composer/autoload_classmap.php'>autoload_classmap.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/composer/autoload_real.php'>autoload_real.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/composer/platform_check.php'>platform_check.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/composer/installed.json'>installed.json</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
			<details>
				<summary><b>symfony</b></summary>
				<blockquote>
					<details>
						<summary><b>polyfill-mbstring</b></summary>
						<blockquote>
							<table>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-mbstring/bootstrap80.php'>bootstrap80.php</a></b></td>
							</tr>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-mbstring/Mbstring.php'>Mbstring.php</a></b></td>
							</tr>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-mbstring/bootstrap.php'>bootstrap.php</a></b></td>
							</tr>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-mbstring/composer.json'>composer.json</a></b></td>
							</tr>
							</table>
							<details>
								<summary><b>Resources</b></summary>
								<blockquote>
									<details>
										<summary><b>unidata</b></summary>
										<blockquote>
											<table>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-mbstring/Resources/unidata/caseFolding.php'>caseFolding.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-mbstring/Resources/unidata/titleCaseRegexp.php'>titleCaseRegexp.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-mbstring/Resources/unidata/lowerCase.php'>lowerCase.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-mbstring/Resources/unidata/upperCase.php'>upperCase.php</a></b></td>
											</tr>
											</table>
										</blockquote>
									</details>
								</blockquote>
							</details>
						</blockquote>
					</details>
					<details>
						<summary><b>polyfill-php80</b></summary>
						<blockquote>
							<table>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-php80/bootstrap.php'>bootstrap.php</a></b></td>
							</tr>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-php80/composer.json'>composer.json</a></b></td>
							</tr>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-php80/PhpToken.php'>PhpToken.php</a></b></td>
							</tr>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-php80/Php80.php'>Php80.php</a></b></td>
							</tr>
							</table>
							<details>
								<summary><b>Resources</b></summary>
								<blockquote>
									<details>
										<summary><b>stubs</b></summary>
										<blockquote>
											<table>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-php80/Resources/stubs/Stringable.php'>Stringable.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-php80/Resources/stubs/UnhandledMatchError.php'>UnhandledMatchError.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-php80/Resources/stubs/ValueError.php'>ValueError.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-php80/Resources/stubs/PhpToken.php'>PhpToken.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-php80/Resources/stubs/Attribute.php'>Attribute.php</a></b></td>
											</tr>
											</table>
										</blockquote>
									</details>
								</blockquote>
							</details>
						</blockquote>
					</details>
					<details>
						<summary><b>polyfill-ctype</b></summary>
						<blockquote>
							<table>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-ctype/bootstrap80.php'>bootstrap80.php</a></b></td>
							</tr>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-ctype/bootstrap.php'>bootstrap.php</a></b></td>
							</tr>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-ctype/composer.json'>composer.json</a></b></td>
							</tr>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/symfony/polyfill-ctype/Ctype.php'>Ctype.php</a></b></td>
							</tr>
							</table>
						</blockquote>
					</details>
				</blockquote>
			</details>
			<details>
				<summary><b>graham-campbell</b></summary>
				<blockquote>
					<details>
						<summary><b>result-type</b></summary>
						<blockquote>
							<table>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/graham-campbell/result-type/composer.json'>composer.json</a></b></td>
							</tr>
							</table>
							<details>
								<summary><b>src</b></summary>
								<blockquote>
									<table>
									<tr>
										<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/graham-campbell/result-type/src/Result.php'>Result.php</a></b></td>
									</tr>
									<tr>
										<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/graham-campbell/result-type/src/Success.php'>Success.php</a></b></td>
									</tr>
									<tr>
										<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/graham-campbell/result-type/src/Error.php'>Error.php</a></b></td>
									</tr>
									</table>
								</blockquote>
							</details>
						</blockquote>
					</details>
				</blockquote>
			</details>
			<details>
				<summary><b>phpoption</b></summary>
				<blockquote>
					<details>
						<summary><b>phpoption</b></summary>
						<blockquote>
							<table>
							<tr>
								<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/phpoption/phpoption/composer.json'>composer.json</a></b></td>
							</tr>
							</table>
							<details>
								<summary><b>src</b></summary>
								<blockquote>
									<details>
										<summary><b>PhpOption</b></summary>
										<blockquote>
											<table>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/phpoption/phpoption/src/PhpOption/LazyOption.php'>LazyOption.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/phpoption/phpoption/src/PhpOption/Some.php'>Some.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/phpoption/phpoption/src/PhpOption/Option.php'>Option.php</a></b></td>
											</tr>
											<tr>
												<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/vendor/phpoption/phpoption/src/PhpOption/None.php'>None.php</a></b></td>
											</tr>
											</table>
										</blockquote>
									</details>
								</blockquote>
							</details>
						</blockquote>
					</details>
				</blockquote>
			</details>
		</blockquote>
	</details>
	<details> <!-- views Submodule -->
		<summary><b>views</b></summary>
		<blockquote>
			<table>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/index.php'>index.php</a></b></td>
			</tr>
			</table>
			<details>
				<summary><b>equipes</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/equipes/add.php'>add.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/equipes/index.php'>index.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/equipes/delete.php'>delete.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/equipes/view.php'>view.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/equipes/compare.php'>compare.php</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
			<details>
				<summary><b>matchs</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/matchs/add.php'>add.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/matchs/index.php'>index.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/matchs/delete.php'>delete.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/matchs/view.php'>view.php</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
			<details>
				<summary><b>prediction</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/prediction/index.php'>index.php</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
			<details>
				<summary><b>joueurs</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/joueurs/add.php'>add.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/joueurs/index.php'>index.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/joueurs/delete.php'>delete.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/joueurs/view.php'>view.php</a></b></td>
					</tr>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/joueurs/compare.php'>compare.php</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
			<details>
				<summary><b>api</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/api/index.php'>index.php</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
			<details>
				<summary><b>classement</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/views/classement/index.php'>index.php</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
		</blockquote>
	</details>
	<details> <!-- public Submodule -->
		<summary><b>public</b></summary>
		<blockquote>
			<details>
				<summary><b>css</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/public/css/styles.css'>styles.css</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
			<details>
				<summary><b>js</b></summary>
				<blockquote>
					<table>
					<tr>
						<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/public/js/main.js'>main.js</a></b></td>
					</tr>
					</table>
				</blockquote>
			</details>
		</blockquote>
	</details>
	<details> <!-- class Submodule -->
		<summary><b>class</b></summary>
		<blockquote>
			<table>
			<tr>
				<td><b><a href='https://github.com/keylian15/WEB_Basket/blob/master/class/myAuthClass.php'>myAuthClass.php</a></b></td>
			</tr>
			</table>
		</blockquote>
	</details>
</details>

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

---

## Project Roadmap

- [x] **`Task 1`**: <strike>Implement feature one.</strike>
- [ ] **`Task 2`**: Implement feature two.
- [ ] **`Task 3`**: Implement feature three.

---

## Contributing

- **💬 [Join the Discussions](https://github.com/keylian15/WEB_Basket/discussions)**: Share your insights, provide feedback, or ask questions.
- **🐛 [Report Issues](https://github.com/keylian15/WEB_Basket/issues)**: Submit bugs found or log feature requests for the `WEB_Basket` project.
- **💡 [Submit Pull Requests](https://github.com/keylian15/WEB_Basket/blob/main/CONTRIBUTING.md)**: Review open PRs, and submit your own PRs.

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

## License

This project is protected under the [SELECT-A-LICENSE](https://choosealicense.com/licenses) License. For more details, refer to the [LICENSE](https://choosealicense.com/licenses/) file.

---

## Acknowledgments

- List any resources, contributors, inspiration, etc. here.

---
