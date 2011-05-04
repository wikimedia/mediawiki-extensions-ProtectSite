<?php
/**
 * Internationalization file for ProtectSite extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Eric Johnston <e.wolfie@gmail.com>
 */
$messages['en'] = array(
	'protectsite' => 'Protect site',
	'protectsite-desc' => 'Allows a site administrator to temporarily block various site modifications',
	'protectsite-text-protect' => '<!-- Instructions/Comments/Policy for use -->',
	'protectsite-text-unprotect' => '<!-- Instructions/Comments when protected -->',
	'protectsite-title' => 'Site protection settings',
	'protectsite-allowall' => 'All users',
	'protectsite-allowusersysop' => 'Registered users and sysops',
	'protectsite-allowsysop' => 'Sysops only',
	'protectsite-createaccount' => 'Allow creation of new accounts by',
	'protectsite-createpage' => 'Allow creation of pages by',
	'protectsite-edit' => 'Allow editing of pages by',
	'protectsite-move' => 'Allow moving of pages by',
	'protectsite-upload' => 'Allow file uploads by',
	'protectsite-timeout' => 'Timeout:',
	'protectsite-timeout-error' => "'''Invalid timeout.'''",
	'protectsite-maxtimeout' => 'Maximum: $1',
	'protectsite-comment' => 'Comment:',
	'protectsite-ucomment' => 'Unprotect comment:',
	'protectsite-until' => 'Protected until:',
	'protectsite-protect' => 'Protect',
	'protectsite-unprotect' => 'Unprotect',

	/* epic message duplication... */
	'protectsite-createaccount-0' => 'All users',
	'protectsite-createaccount-1' => 'Registered users and sysops',
	'protectsite-createaccount-2' => 'Sysops only',
	'protectsite-createpage-0' => 'All users',
	'protectsite-createpage-1' => 'Registered users and sysops',
	'protectsite-createpage-2' => 'Sysops only',
	'protectsite-edit-0' => 'All users',
	'protectsite-edit-1' => 'Registered users and sysops',
	'protectsite-edit-2' => 'Sysops only',
	'protectsite-move-0' => 'Registered users and sysops',
	'protectsite-move-1' => 'Sysops only',
	'protectsite-upload-0' => 'Registered users and sysops',
	'protectsite-upload-1' => 'Sysops only',
	/* end epic message duplication */

	'right-protectsite' => 'Limit actions that can be performed for some groups for a limited time',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'protectsite-allowall' => 'Alle gebruikers',
	'protectsite-protect' => 'Beskerm',
	'protectsite-unprotect' => 'Verwyder beskerming',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 * @author Gwenn-Ael
 */
$messages['br'] = array(
	'protectsite' => "Gwareziñ al lec'hienn",
	'protectsite-allowall' => 'An holl implijerien',
	'protectsite-allowsysop' => 'Merourien hepken',
	'protectsite-allowusersysop' => 'Implijerien enrollet ha merourien',
	'protectsite-comment' => 'Evezhiadenn :',
	'protectsite-createaccount' => 'Aotren da grouiñ kontoù nevez dre',
	'protectsite-createpage' => 'Aotren da grouiñ pajennoù dre',
	'protectsite-edit' => 'Aotren da gemm pajennoù dre',
	'protectsite-maxtimeout' => 'Maximum : $1',
	'protectsite-move' => 'Aotren da adenvel pajennoù dre',
	'protectsite-protect' => 'Gwareziñ',
	'protectsite-text-protect' => '<!-- Kemennoù / Displegadennoù / Reolennoù implijout -->',
	'protectsite-text-unprotect' => '<!-- Kemennoù / Displegadennoù pa vez gwarezet -->',
	'protectsite-timeout' => 'Termen',
	'protectsite-timeout-error' => "'''Termen direizh.'''",
	'protectsite-title' => "Arventennoù gwareziñ al lec'hienn",
	'protectsite-ucomment' => 'Evezhiadenn war an diwareziñ',
	'protectsite-unprotect' => 'Diwareziñ',
	'protectsite-until' => 'Gwarezet betek :',
	'protectsite-upload' => 'Aotren da enporzhiañ restroù dre',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'protectsite' => 'Абарона сайту',
	'protectsite-text-protect' => '<!-- Інструкцыі/Камэнтары/Правілы выкарыстаньня -->',
	'protectsite-text-unprotect' => '<!-- Інструкцыі/Камэнтары, калі працуе абарона -->',
	'protectsite-title' => 'Устаноўкі абароны сайту',
	'protectsite-allowall' => 'Усім удзельнікам',
	'protectsite-allowusersysop' => 'Зарэгістраваным удзельнікам і адміністратарам',
	'protectsite-allowsysop' => 'Толькі адміністратарам',
	'protectsite-createaccount' => 'Дазволіць стварэньне новых рахункаў',
	'protectsite-createpage' => 'Дазволіць стварэньне старонак',
	'protectsite-edit' => 'Дазволіць рэдагаваньне старонак',
	'protectsite-move' => 'Дазволіць перанос старонак',
	'protectsite-upload' => 'Дазволіць загрузку файлаў',
	'protectsite-timeout' => 'Час дзеяньня абароны:',
	'protectsite-timeout-error' => "'''Няслушны час дзеяньня абароны.'''",
	'protectsite-maxtimeout' => 'Максымум:',
	'protectsite-comment' => 'Камэнтар:',
	'protectsite-ucomment' => 'Камэнтар зьняцьця абароны:',
	'protectsite-until' => 'Абаронены да:',
	'protectsite-protect' => 'Абараніць',
	'protectsite-unprotect' => 'Зьняць абарону',
);

/** German (Deutsch)
 * @author LWChris
 */
$messages['de'] = array(
	'protectsite' => 'Seite schützen',
	'protectsite-text-protect' => '<!-- Anweisungen/Kommentare/Richtlinie zur Verwendung -->',
	'protectsite-text-unprotect' => '<!-- Anweisungen/Kommentare wenn geschützt -->',
	'protectsite-title' => 'Seitenschutz Einstellungen',
	'protectsite-allowall' => 'Alle Benutzer',
	'protectsite-allowusersysop' => 'Registrierte Benutzer und Administratoren',
	'protectsite-allowsysop' => 'Nur Administratoren',
	'protectsite-createaccount' => 'Erlaube die Erstellung neuer Accounts von',
	'protectsite-createpage' => 'Erlaube Erstellung von Seiten von',
	'protectsite-edit' => 'Erlaube Bearbeiten von Seiten von',
	'protectsite-move' => 'Erlaube Verschieben von Seiten von',
	'protectsite-upload' => 'Erlaube Datei-Uploads von',
	'protectsite-timeout' => 'Sperrdauer:',
	'protectsite-timeout-error' => "'''Ungültige Sperrdauer.'''",
	'protectsite-maxtimeout' => 'Maximum:',
	'protectsite-comment' => 'Grund:',
	'protectsite-ucomment' => 'Aufhebungsgrund:',
	'protectsite-until' => 'Geschützt bis:',
	'protectsite-protect' => 'Schützen',
	'protectsite-unprotect' => 'Freigeben',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author LWChris
 */
$messages['de-formal'] = array(
	'protectsite' => 'Seite schützen',
	'protectsite-text-protect' => '<!-- Anweisungen/Kommentare/Richtlinie zur Verwendung -->',
	'protectsite-text-unprotect' => '<!-- Anweisungen/Kommentare wenn geschützt -->',
	'protectsite-title' => 'Seitenschutz Einstellungen',
	'protectsite-allowall' => 'Alle Benutzer',
	'protectsite-allowusersysop' => 'Registrierte Benutzer und Administratoren',
	'protectsite-allowsysop' => 'Nur Administratoren',
	'protectsite-createaccount' => 'Erlaube die Erstellung neuer Accounts von',
	'protectsite-createpage' => 'Erlaube Erstellung von Seiten von',
	'protectsite-edit' => 'Erlaube Bearbeiten von Seiten von',
	'protectsite-move' => 'Erlaube Verschieben von Seiten von',
	'protectsite-upload' => 'Erlaube Datei-Uploads von',
	'protectsite-timeout' => 'Sperrdauer:',
	'protectsite-timeout-error' => "'''Ungültige Sperrdauer.'''",
	'protectsite-maxtimeout' => 'Maximum:',
	'protectsite-comment' => 'Grund:',
	'protectsite-ucomment' => 'Aufhebungsgrund:',
	'protectsite-until' => 'Geschützt bis:',
	'protectsite-protect' => 'Schützen',
	'protectsite-unprotect' => 'Freigeben',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Peter17
 * @author Translationista
 */
$messages['es'] = array(
	'protectsite' => 'Proteger el sitio',
	'protectsite-text-protect' => '<!-- Instrucciones/Comentario/Políticas de uso -->',
	'protectsite-text-unprotect' => '<!-- Instrucciones/Comentarios al estar protegidos-->',
	'protectsite-title' => 'Configuraciones de protección de sitio',
	'protectsite-allowall' => 'Todos los usuarios',
	'protectsite-allowusersysop' => 'Usuarios registrados y administradores de sistema',
	'protectsite-allowsysop' => 'Sólo administradores de sistema',
	'protectsite-createaccount' => 'Permitir creción de nuevas cuentas por',
	'protectsite-createpage' => 'Permitir creación de páginas por',
	'protectsite-edit' => 'Permitir edición de páginas por',
	'protectsite-move' => 'Permitir movimiento de páginas por',
	'protectsite-upload' => 'Permitir cargas de archivo por',
	'protectsite-timeout' => 'Tiempo de espera:',
	'protectsite-timeout-error' => "'''Tiempo de espera inválido.'''",
	'protectsite-maxtimeout' => 'Máximo:',
	'protectsite-comment' => 'Comentario:',
	'protectsite-ucomment' => 'Desproteger comentario:',
	'protectsite-until' => 'Protegido hasta:',
	'protectsite-protect' => 'Proteger',
	'protectsite-unprotect' => 'Desproteger',
);

/** Finnish (Suomi)
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['fi'] = array(
	'protectsite' => 'Suojaa sivusto',
	'protectsite-title' => 'Sivuston suojauksen asetukset',
	'protectsite-allowall' => 'Kaikki käyttäjät',
	'protectsite-allowusersysop' => 'Rekisteröityneet käyttäjät ja ylläpitäjät',
	'protectsite-allowsysop' => 'Vain ylläpitäjät',
	'protectsite-createaccount' => 'Salli seuraavien luoda uusia tunnuksia',
	'protectsite-createpage' => 'Salli seuraavien luoda uusia sivuja',
	'protectsite-edit' => 'Salli seuraavien muokata sivuja',
	'protectsite-move' => 'Salli seuraavien siirtää sivuja',
	'protectsite-upload' => 'Salli seuraavien tallentaa tiedostoja',
	'protectsite-timeout' => 'Aikakatkaisu:',
	'protectsite-timeout-error' => "'''Kelpaamaton aikakatkaisu.'''",
	'protectsite-maxtimeout' => 'Maksimi: $1',
	'protectsite-comment' => 'Kommentti:',
	'protectsite-ucomment' => 'Suojauksen poiston kommentti: ',
	'protectsite-protect' => 'Suojaa',
	'protectsite-unprotect' => 'Poista suojaus',
	'right-protectsite' => 'Rajoittaa toimintoja, joita jotkin ryhmät voivat tehdä, tietyn aikaa',
);

/** French (Français)
 * @author Alexandre Emsenhuber
 */
$messages['fr'] = array(
	'protectsite' => 'Protéger le site',
	'protectsite-text-protect' => "<!-- Instructions / Commentaires / Règles d'utilisation -->",
	'protectsite-text-unprotect' => '<!-- Instructions / Commentaires lorsque protégé -->',
	'protectsite-title' => 'Paramètres de la protection du site',
	'protectsite-allowall' => 'Tous les utilisateurs',
	'protectsite-allowusersysop' => 'Utilisateurs enregistrés et administrateurs',
	'protectsite-allowsysop' => 'Administrateurs seulement',
	'protectsite-createaccount' => 'Autoriser la création de nouveaux comptes par',
	'protectsite-createpage' => 'Autoriser la création de comptes par',
	'protectsite-edit' => 'Autoriser les modifications de pages par',
	'protectsite-move' => 'Autoriser le renommage de pages par',
	'protectsite-upload' => 'Autoriser les imports de fichiers par',
	'protectsite-timeout' => 'Expiration :',
	'protectsite-timeout-error' => "'''Expiration invalide.'''",
	'protectsite-maxtimeout' => 'Maximum : $1',
	'protectsite-comment' => 'Commentaire :',
	'protectsite-ucomment' => 'Commentaire de déprotection : ',
	'protectsite-until' => "Protéger jusqu'à : ",
	'protectsite-protect' => 'Protéger',
	'protectsite-unprotect' => 'Déprotéger',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'protectsite' => 'Protexer o sitio',
	'protectsite-text-protect' => '<!-- Instrucións/Comentarios/Política de uso -->',
	'protectsite-text-unprotect' => '<!-- Instrucións/Comentarios durante a protección -->',
	'protectsite-title' => 'Configuración da protección do sitio',
	'protectsite-allowall' => 'Todos os usuarios',
	'protectsite-allowusersysop' => 'Usuarios rexistrados e administradores',
	'protectsite-allowsysop' => 'Administradores soamente',
	'protectsite-createaccount' => 'Permitir a creación de novas contas por',
	'protectsite-createpage' => 'Permitir a creación de páxinas por',
	'protectsite-edit' => 'Permitir a edición de páxinas por',
	'protectsite-move' => 'Permitir o traslado de páxinas por',
	'protectsite-upload' => 'Permitir a carga de ficheiros por',
	'protectsite-timeout' => 'Remate:',
	'protectsite-timeout-error' => "'''Tempo de caducidade inválido.'''",
	'protectsite-maxtimeout' => 'Máximo: $1',
	'protectsite-comment' => 'Comentario:',
	'protectsite-ucomment' => 'Comentario de desprotección: ',
	'protectsite-until' => 'Protexido ata: ',
	'protectsite-protect' => 'Protexer',
	'protectsite-unprotect' => 'Desprotexer',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'protectsite' => 'Oldal védelme',
	'protectsite-title' => 'Oldal védelmi beállításai',
	'protectsite-allowall' => 'Összes felhasználó',
	'protectsite-allowsysop' => 'Csak adminisztrátorok',
	'protectsite-timeout' => 'Időtúllépés:',
	'protectsite-maxtimeout' => 'Legfeljebb:',
	'protectsite-comment' => 'Megjegyzés:',
	'protectsite-ucomment' => 'Védelem feloldása megjegyzés:',
	'protectsite-protect' => 'Védelem',
	'protectsite-unprotect' => 'Védelem feloldása',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'protectsite' => 'Proteger sito',
	'protectsite-text-protect' => '<!-- Instructiones/Commentos/Politica pro uso -->',
	'protectsite-text-unprotect' => '<!-- Instructiones/Commentos quando protegite -->',
	'protectsite-title' => 'Configuration del protection del sito',
	'protectsite-allowall' => 'Tote le usatores',
	'protectsite-allowusersysop' => 'Usatores registrate e administratores',
	'protectsite-allowsysop' => 'Administratores solmente',
	'protectsite-createaccount' => 'Permitter le creation de nove contos per',
	'protectsite-createpage' => 'Permitter le creation de paginas per',
	'protectsite-edit' => 'Permitter le modification de paginas per',
	'protectsite-move' => 'Permitter le renomination de paginas per',
	'protectsite-upload' => 'Permitter le incargamento de files per',
	'protectsite-timeout' => 'Expiration:',
	'protectsite-timeout-error' => "'''Expiration invalide.'''",
	'protectsite-maxtimeout' => 'Maximo:',
	'protectsite-comment' => 'Commento:',
	'protectsite-ucomment' => 'Commento de disprotection:',
	'protectsite-until' => 'Protegite usque a:',
	'protectsite-protect' => 'Proteger',
	'protectsite-unprotect' => 'Disproteger',
);

/** Indonesian (Bahasa Indonesia)
 * @author Kenrick95
 */
$messages['id'] = array(
	'protectsite-comment' => 'Komentar:',
	'protectsite-protect' => 'Lindungi',
);

/** Italian (Italiano) */
$messages['it'] = array(
	'protectsite-allowall' => 'Tutti gli utenti',
	'protectsite-maxtimeout' => 'Massimo:',
	'protectsite-comment' => 'Oggetto:',
);

/** Japanese (日本語)
 * @author Tommy6
 * @author 青子守歌
 */
$messages['ja'] = array(
	'protectsite' => 'サイトの保護',
	'protectsite-text-protect' => '<!-- 利用時の方針/コメント/指示 -->',
	'protectsite-text-unprotect' => '<!-- 保護された時のコメント/指示 -->',
	'protectsite-title' => 'サイト保護の設定',
	'protectsite-allowall' => '全利用者',
	'protectsite-allowusersysop' => '登録利用者および管理者',
	'protectsite-allowsysop' => '管理者のみ',
	'protectsite-createaccount' => '新規アカウント作成を許可する利用者グループ',
	'protectsite-createpage' => 'ページ作成を許可する利用者グループ',
	'protectsite-edit' => '編集を許可する利用者グループ',
	'protectsite-move' => 'ページの移動を許可する利用者グループ',
	'protectsite-upload' => 'ファイルのアップロードを許可する利用者グループ',
	'protectsite-timeout' => '期間:',
	'protectsite-timeout-error' => "'''期間設定が不適切です'''",
	'protectsite-maxtimeout' => '最大:',
	'protectsite-comment' => '保護の理由:',
	'protectsite-ucomment' => '保護解除の理由:',
	'protectsite-until' => '保護期限：',
	'protectsite-protect' => '保護',
	'protectsite-unprotect' => '保護解除',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'protectsite' => 'Site schützen',
	'protectsite-text-protect' => '<!-- Instruktiounen/Commentairen/Richtlinne fir de Gebrauch -->',
	'protectsite-title' => 'Astellunge vun de Späre vum Site',
	'protectsite-allowall' => 'All Benotzer',
	'protectsite-allowusersysop' => 'Registréiert Benotzer an Administrateuren',
	'protectsite-allowsysop' => 'Nëmmen Administrateuren',
	'protectsite-createaccount' => 'Erlabe vum Uleeë vun neie Benotzerkonten duerch',
	'protectsite-createpage' => "Erlaabt d'Uleeë vu Säiten duerch",
	'protectsite-edit' => 'Erlabe vum Ännere vu Säiten duerch',
	'protectsite-move' => "D'Réckele vu Säiten erlaben fir",
	'protectsite-upload' => "D'Eropluede vu Fichieren erlaben fir",
	'protectsite-maxtimeout' => 'Maximum:',
	'protectsite-comment' => 'Bemierkung:',
	'protectsite-ucomment' => "Grond fir d'Ophiewe vun der Spär:",
	'protectsite-until' => 'Gespaart bis:',
	'protectsite-protect' => 'Spären',
	'protectsite-unprotect' => 'Spär ophiewen',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'protectsite' => 'Заштити веб-страница',
	'protectsite-text-protect' => '<!-- Инструкции/Коментари/Правила на употреба -->',
	'protectsite-text-unprotect' => '<!-- Инструкции/Коментари кога е заштитено -->',
	'protectsite-title' => 'Нагодувања на заштитата на веб-страната',
	'protectsite-allowall' => 'Сите корисници',
	'protectsite-allowusersysop' => 'Регистрирани корисници и систем-оператори',
	'protectsite-allowsysop' => 'Само систем-оператори',
	'protectsite-createaccount' => 'Дозволи создавање на нови сметки од',
	'protectsite-createpage' => 'Дозволи создавање на страници од',
	'protectsite-edit' => 'Дозволи уредување на страници од',
	'protectsite-move' => 'Дозволи преместување на страници од',
	'protectsite-upload' => 'Дозволи подигање на податотеки од',
	'protectsite-timeout' => 'Истекува:',
	'protectsite-timeout-error' => "'''Неважечки истек.'''",
	'protectsite-maxtimeout' => 'Максимум: $1',
	'protectsite-comment' => 'Коментар:',
	'protectsite-ucomment' => 'Тргни заштита од коментар: ',
	'protectsite-until' => 'Заштитено до: ',
	'protectsite-protect' => 'Заштити',
	'protectsite-unprotect' => 'Тргни заштита',
);

/** Dutch (Nederlands)
 * @author Mark van Alphen
 */
$messages['nl'] = array(
	'protectsite' => 'Beveilig site',
	'protectsite-title' => 'Site beveilig instellingen',
	'protectsite-allowall' => 'Alle gebruikers',
	'protectsite-allowusersysop' => 'Geregistreerde gebruikers en beheerders',
	'protectsite-allowsysop' => 'Alleen beheerders',
	'protectsite-createaccount' => 'Sta creatie van nieuwe accounts toe voor',
	'protectsite-createpage' => "Sta creatie van pagina's toe voor",
	'protectsite-edit' => "Sta bewerken van pagina's toe voor",
	'protectsite-move' => "Sta hernoemen van pagina's toe voor",
	'protectsite-upload' => 'Sta bestand-uploads toe voor',
	'protectsite-timeout' => 'Verloop:',
	'protectsite-timeout-error' => "'''Ongeldig verloop.'''",
	'protectsite-maxtimeout' => 'Maximum: $1',
	'protectsite-comment' => 'Opmerking:',
	'protectsite-ucomment' => 'Beveiliging-opheffing opmerkingen: ',
	'protectsite-until' => 'Beveiligd tot: ',
	'protectsite-protect' => 'Beveilig',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'protectsite' => 'Beskytt side',
	'protectsite-text-protect' => '<!-- Instruksjoner/kommentarer/fremgangsmåte for bruk -->',
	'protectsite-text-unprotect' => '<!-- Instruksjoner/kommentarer når beskyttet -->',
	'protectsite-title' => 'Innstillinger for sidebeskyttelse',
	'protectsite-allowall' => 'Alle brukere',
	'protectsite-allowusersysop' => 'Registrerte brukere og systemoperatører',
	'protectsite-allowsysop' => 'Kun systemoperatører',
	'protectsite-createaccount' => 'Tillat opprettelse av nye kontoer av',
	'protectsite-createpage' => 'Tillat opprettelse av sider av',
	'protectsite-edit' => 'Tillat redigering av sider av',
	'protectsite-move' => 'Tillat flytting av sider av',
	'protectsite-upload' => 'Tillat filopplasting av',
	'protectsite-timeout' => 'Tidsavbrudd:',
	'protectsite-timeout-error' => "'''Ugyldig tidsavbrudd.'''",
	'protectsite-maxtimeout' => 'Maksimum:',
	'protectsite-comment' => 'Kommentar:',
	'protectsite-ucomment' => 'Opphev beskyttelse av kommentar:',
	'protectsite-until' => 'Beskyttet til:',
	'protectsite-protect' => 'Beskytt',
	'protectsite-unprotect' => 'Opphev beskyttelse',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'protectsite-comment' => 'Grund:',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'protectsite' => 'Sit protet',
	'protectsite-text-protect' => '<!-- Istrussion/Coment/Polìtica për dovragi -->',
	'protectsite-text-unprotect' => '<!-- Istrussion/Coment quand protet -->',
	'protectsite-title' => 'Ampostassion ëd protession dël sit',
	'protectsite-allowall' => "Tùit j'utent",
	'protectsite-allowusersysop' => 'Utent registrà e aministrador',
	'protectsite-allowsysop' => 'Mach aministrador',
	'protectsite-createaccount' => 'Përmëtt creassion ëd neuv utent da',
	'protectsite-createpage' => 'Përmëtt creassion ëd pàgine da',
	'protectsite-edit' => 'Përmëtt modìfica ëd pàgine da',
	'protectsite-move' => 'Përmëtt tramuda ëd pàgine da',
	'protectsite-upload' => 'Përmëtt caria ëd pàgine da',
	'protectsite-timeout' => 'Timeout:',
	'protectsite-timeout-error' => "'''Timeout pa bon.'''",
	'protectsite-maxtimeout' => 'Màssim: $1',
	'protectsite-comment' => 'Coment:',
	'protectsite-ucomment' => 'Sprotegg coment: ',
	'protectsite-until' => 'Protegg fin a: ',
	'protectsite-protect' => 'Protet',
	'protectsite-unprotect' => 'Sprotet',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'protectsite-allowall' => 'ټول کارنان',
	'protectsite-protect' => 'ژغورل',
	'protectsite-unprotect' => 'نه ژغورل',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'protectsite-allowall' => 'Todos os usuários',
	'protectsite-allowusersysop' => 'Usuários registrados e administradores',
	'protectsite-allowsysop' => 'Somente administradores',
	'protectsite-maxtimeout' => 'Máximo:',
	'protectsite-protect' => 'Proteger',
	'protectsite-unprotect' => 'Desproteger',
);

/** Russian (Русский)
 * @author Lockal
 */
$messages['ru'] = array(
	'protectsite' => 'Защита сайта',
	'protectsite-allowall' => 'Всем участникам',
	'protectsite-allowusersysop' => 'Зарегистрированным участникам и администраторам',
	'protectsite-allowsysop' => 'Только администраторам',
	'protectsite-createaccount' => 'Разрешить создание новых учётных записей',
	'protectsite-createpage' => 'Разрешить создание страниц',
	'protectsite-edit' => 'Разрешить правку страниц',
	'protectsite-maxtimeout' => 'Максимум:',
	'protectsite-move' => 'Разрешить переименование страниц',
	'protectsite-protect' => 'Защитить',
	'protectsite-text-protect' => '<!-- Инструкции/Комментарии/Правила для использования -->',
	'protectsite-text-unprotect' => '<!-- Инструкции/Комментарии при установленной защите -->',
	'protectsite-timeout' => 'Время истечения:',
	'protectsite-timeout-error' => "'''Неверное время истечения.'''",
	'protectsite-title' => 'Настройки защиты сайта',
	'protectsite-ucomment' => 'Комментарий снятия защиты:',
	'protectsite-unprotect' => 'Снять защиту',
	'protectsite-until' => 'Защищено до:',
	'protectsite-upload' => 'Разрешить загрузку файлов',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'protectsite-allowall' => 'Сви корисници',
	'protectsite-allowusersysop' => 'Регистровани корисници и Администратори',
	'protectsite-allowsysop' => 'Само администратори',
	'protectsite-createpage' => 'Дозволи стварање страна од',
	'protectsite-edit' => 'Дозволи уређивање страна од стране',
	'protectsite-move' => 'Дозволи преусмеравање страна од стране',
	'protectsite-timeout' => 'Време истекло (тајмаут)',
	'protectsite-maxtimeout' => 'Максимум:',
	'protectsite-comment' => 'Коментар:',
	'protectsite-until' => 'Заштићена јединица',
	'protectsite-protect' => 'Заштити',
	'protectsite-unprotect' => 'Скини заштиту',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'protectsite-text-protect' => '<!-- ఉపయోగించడానికి సూచనలు/వ్యాఖ్యలు/విధానం -->',
	'protectsite-title' => 'సైటు సంరక్షణ అమరికలు',
	'protectsite-allowall' => 'అందరు వాడుకరులు',
	'protectsite-allowusersysop' => 'నమోదైన వాడుకరులు మరియు నిర్వాహకులు',
	'protectsite-allowsysop' => 'నిర్వాహకులు మాత్రమే',
	'protectsite-maxtimeout' => 'గరిష్ఠం:',
	'protectsite-comment' => 'వ్యాఖ్య:',
	'protectsite-protect' => 'సంరక్షించు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'protectsite' => 'Prutektahan ang sayt',
	'protectsite-text-protect' => '<!-- Magagamit na mga tagubilin/Mga puna/Patakaran -->',
	'protectsite-text-unprotect' => '<!-- Mga tagubilin/Mga puna kapag nakasanggalang -->',
	'protectsite-title' => 'Mga katakdaang pamprutekta ng sityo',
	'protectsite-allowall' => 'Lahat ng mga tagagamit',
	'protectsite-allowusersysop' => 'Nakatalang mga tagagamit at mga tagapagpaandar ng sistema',
	'protectsite-allowsysop' => 'Mga tagapagpaandar lang ng sistema',
	'protectsite-createaccount' => 'Ipahintulot ang paglikha ng bagong mga akawnt sa pamamagitan ng',
	'protectsite-createpage' => 'Ipahintulot ang paglikha ng pahina sa pamamagitan ng',
	'protectsite-edit' => 'Pahintulutan ang pamamatnugot ng mga pahina sa pamamagitan ng',
	'protectsite-move' => 'Ipahintulot ang paglipat ng mga pahina sa pamamagitan ng',
	'protectsite-upload' => 'Ipahintulot ang paitaas na pagkakarga ng mga talaksan sa pamamagitan ng',
	'protectsite-timeout' => 'Pamamahinga:',
	'protectsite-timeout-error' => "'''Hindi Tanggap na Pamamahinga.'''",
	'protectsite-maxtimeout' => 'Pinakamataas:',
	'protectsite-comment' => 'Puna:',
	'protectsite-ucomment' => 'Huwag prutektahan ang puna:',
	'protectsite-until' => 'Isanggalang hanggang:',
	'protectsite-protect' => 'Isanggalang',
	'protectsite-unprotect' => 'Huwag isanggalang',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'protectsite-title' => 'Налаштування захисту сайту',
);
