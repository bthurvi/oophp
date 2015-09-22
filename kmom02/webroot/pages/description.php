<h1>Redovisningar</h1>

<h4>Kmom02 - <a href="http://dbwebb.se/oophp/kmom02">Objektorienterad programmering i PHP</a></h4>

<p>Jag känner ganska väl till objektorienterade koncept och programmeringssätt. Därför valde jag att endast skumläsa guiden oophp20 och sedan ge mig i kast med uppgifterna. Jag tror att jag har lyckats hyfsat med båda - men vi får se vad den som bedömmer mina lösningar säger...</p>

<p>Tärningsspelet 100 skulle fungera så att en spelare kunde spela. Som extra uppgifter kunde man göra så att flera spelare kunde spela mot varandra, eller så att man kunde spela mot datorn. Jag valde att göra en lösning som förenar dessa krav på en gång genom att låta besökaren ange hur många mänskliga respektive datorspelare (AI:n) som skall spela.</p>

<p>Utifrån användarens val skapas instanser av klasserna, CPlayer, C3Player, C15PointPlayer. Klassen CPlayer representerar en mänsklig spelare. Klasserna C3Player och C15PointPlayer ärver av klassen CPlayer samt utökar den med olika artificiell intelligens. Instanserna lagras sedan i en medlemsvariabel (array) i klassen CGame som representerar hela tärningsspelet. CGame har även en artificiell tärning i form av en instans av klassen C6Dice.</p>

<p>För att webbplatsen skall kunna hålla reda på hela spelet mellan page-reloads så lagras hela spelets instans i en sessionsvariabel av <a href="?p=code&path=webroot/pages/dicegame.php">dicegame-sidan</a></p>

<p>Samtliga klasser ligger sorterade i <a href="?p=code&path=src/dicegame/">dicegame-mapp</a>(de laddas av AutoLoaderns callback funktion).</p>

<p>Jobbigast med själva uppgiften var faktiskt inte objektorienteringen utan var nog snarare meny och spellogiken. Personligen tycker jag att det ibland kan vara lite besvärligt att avgöra via if-satser och villkor när olika saker skall ske och inte.</p>

<p>Kalenderuppgiften “månadens babe” (märkligt nästan sexsistiskt namn förrresten) var i mitt tycker något enklare. Den löste jag endast via två klasser: CCalendar och CsvMonths. CsvMonths innehåller endast svenska namn på månaderna (jag valde en sådan lösning istället för att förlita mig på locale-funktionen.) CCalendar håller reda på aktuell månad och år, plockar fram datumen samt skapar själva html-koden med bild och tabell.  Via lite kod från <a href="http://victor.se/bjorn/holidays.php">Björn Viktor</a> färgas dessutom  alla röda dagar under månaden/året.</p>

<p>Sammanfattningsvis kan man säga att jag hade några få besvär,svårigheter och problem med logiken men löste det. Kursmomenten tycker jag har gett mig ökad erfarenhet i objektorienterad programmering Resultatet tycker jag blev hyfsat (även om koden säkerligen går att förfina, förenkla och göra elegantare). De lärdomar som dessa båda uppgifter har gett mig är ökad förståelse för variablers synlighet i samband med objektorienterad programmering (exempelvis parent:: och self::). Uppgifterna har även gett mig ökad erfarenhet av att få klass-instanser att samverka med varandra (som t.ex.C3Player och CDice). </p>

<p>&nbsp;</p>
<hr>

<h4>Kmom01 - <a href="http://dbwebb.se/oophp/kmom01">Kom igång med programmering i PHP</a></h4>

<p>Jag använder utvecklingsmiljön NetBeans till kodandet av uppgifterna i denna kurs.</p>
<p>Guiden 20 steg för att komma igång med PHP har jag i ärlighetens namn bara skummat igenom. Vid genomläsningen föreföll det inte vara särskilt mycket nytt för mig. Jag upplevde att jag kunde det mesta och valde därför att gå vidare med själva kodandet av anax.</p>
<p>Min version av anax valde jag att kalla för urbax, eller förkortat UV-ax. Där Ax-ändelsen kommer  från anax och UV är mina initialer. Som du som läser detta kan se ovan tillverkade jag även en egen logga och favicon till urbax. Eftersom jag råkar heta Urban blev loggan och faviconen inspierad av bebyggelse (Urban betyder ju även stad). Min tanke är att loggan eventuellt kan fungera att använda till kunskapsmomentet 07/10. Min tanke är nämligen att eventuellt byta ut RM Rental Movies till Rental accommodations, dvs hus och lägenheter. När jag kommer så långt i kursen får vi se hur och om det blir så... </p>

<p>Det enklaste sättet att bygga denna webbplats utifrån anax-basen hade naturligtvis varit att bara klona git-koden och sedan byta några namn. Men eftersom jag gärna vill ha koll på vad jag gör i koden så valde jag istället att bygga allt från grunden enligt mos guide. Lite mer jobb men mycket bättre förståelse enligt mitt sätt att se på saken. Samtidigt som jag följde guiden ändrade en del i css-en från anax, bytte typsnitt, ändrade menyutformning och valde att centrera vissa sidelement som rubriker och så. I övrigt tyckte jag att den vita designen fick vara kvar.</p>

<p>Själva strukturen i Anax trivs jag ganska bra med, men jag gjorde några ändringar till mitt urbax. Bland annat skapade jag en index-sida som inkulderar header, navigation och footer (så slipper jag ha med den koden i varje page-controller). Index-pagecontrollern styr via navigation.php vilket sid-innehåll som skall laddas. Innehållet till de olika sidorna (som ligger i pages-mappen) överförs där I(i navigation.php) till variabeln  jag content. En utskrift av innehållet i content sker sedan vid renderingen, dvs templatefilen (index.tpl.php). Eventuellt kan användandet av get-variabel för navigering innebära lite besvärligar rewrite-rules än vanligt när man tänker mvc (men om det blir aktuellt i den här kursen återstår att se). En annan anledning till att det blev en get-lösning beror nog på att guiden om de dynamiska navigationselementet (klassen cNavigation) var skriven på det sättet... </p>

<p>Det jag tycker att jag har lärt mig av det här kursmomentet är främst autoloaderfunktionen. <strong>spl_autoload_register</strong> hade jag inte hört talas om tidigare. Likaså var strukturen med en  callbackfunktion för att hantera aktiv sida i menyn ny för mig. Ett hyffsat smidigt förfaringssätt tycker jag.</p>

<p>Det gick bra för mig att inkludera source.php som en modul. först fick jag lov att lägga till en get-parameter i sökvägen för breadcrumben, mapparna och filerna eftersom jag använder mig av en index-sida med get parametrar. Jag fick även fixa lite med CSS-en för att få en snygg utskrift. </p>
  
<p>Efter uppladdningen av av detta, kmom01, gjorde jag även extrauppgiften med GitHub - eftersom jag ville påminna mig om det. Jag hade gjort det förr, någon gång, men glömt en del. Det sägs ju att repetition är kunskapens moder...</p>
