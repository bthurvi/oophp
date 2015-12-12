-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 12 dec 2015 kl 13:18
-- Serverversion: 5.6.17
-- PHP-version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `movie`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` char(12) DEFAULT NULL,
  `slug` char(80) DEFAULT NULL,
  `url` char(80) DEFAULT NULL,
  `type` char(80) DEFAULT NULL,
  `title` varchar(80) DEFAULT NULL,
  `data` text,
  `filter` char(80) DEFAULT NULL,
  `category` char(20) DEFAULT NULL,
  `published` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumpning av Data i tabell `content`
--

INSERT INTO `content` (`id`, `author`, `slug`, `url`, `type`, `title`, `data`, `filter`, `category`, `published`, `created`, `updated`, `deleted`) VALUES
(1, 'admin', 'hem', 'hem', 'page', 'Hem', 'Detta är min hemsida. Den är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\n\nDessutom finns ett filter ''nl2br'' som lägger in <br>-element istället för \\n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar.', 'bbcode,nl2br', NULL, '2015-11-05 16:09:16', '2015-11-05 16:09:16', NULL, NULL),
(2, 'admin', 'om', 'om', 'page', 'Om', 'Detta är en sida om mig och min webbplats. Den är skriven i [Markdown](http://en.wikipedia.org/wiki/Markdown). Markdown innebär att du får bra kontroll över innehållet i din sida, du kan formattera och sätta rubriker, men du behöver inte bry dig om HTML.\n\nRubrik nivå 2\n-------------\n\nDu skriver enkla styrtecken för att formattera texten som **fetstil** och *kursiv*. Det finns ett speciellt sätt att länka, skapa tabeller och så vidare.\n\n###Rubrik nivå 3\n\nNär man skriver i markdown så blir det läsbart även som textfil och det är lite av tanken med markdown.', 'markdown', NULL, '2015-11-05 16:09:16', '2015-11-05 16:09:16', NULL, NULL),
(3, 'admin', 'blogpost-1', NULL, 'post', 'Välkommen till min blogg!', 'Detta är en bloggpost.\n\nNär det finns länkar till andra webbplatser så kommer de länkarna att bli klickbara.\n\nhttp://dbwebb.se är ett exempel på en länk som blir klickbar.', 'link,nl2br', NULL, '2015-11-05 16:09:16', '2015-11-05 16:09:16', NULL, NULL),
(4, 'admin', 'blogpost-2', NULL, 'post', 'Nu har sommaren kommit', 'Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost.', 'nl2br', NULL, '2015-11-05 16:09:16', '2015-11-05 16:09:16', NULL, NULL),
(5, 'admin', 'blogpost-3', NULL, 'post', 'Nu har hösten kommit', 'Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost', 'nl2br', NULL, '2015-11-05 16:09:16', '2015-11-05 16:09:16', NULL, '2015-11-06 09:47:32'),
(6, 'doe', 'gurka', 'gurka', 'post', 'gurka', 'Det var en gång en liten gurka som hette Urban.', 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 11:08:14', '2015-11-17 11:08:46', '2015-11-17 11:09:10'),
(7, 'doe', 'kolla-kolla', 'kolla-kolla', 'page', 'kolla kolla', NULL, 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 11:28:30', NULL, '2015-11-17 12:11:35'),
(8, 'doe', 'sld-fksd-lk', 'sld-fksd-lk', 'post', 'sldöfksdölk', NULL, 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 12:13:28', NULL, '2015-11-17 12:14:39'),
(9, 'doe', 'sdlkfsl', 'sdlkfsl', 'post', 'sdlkfsl', NULL, 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 12:17:24', NULL, '2015-11-17 13:39:30'),
(10, 'doe', 'ur-ban-te-star', 'ur-ban-te-star', 'post', 'ur ban te star', NULL, 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 12:20:20', NULL, '2015-11-17 13:10:08'),
(11, 'doe', 'ffffiiiinnnn-sidannnnnn', 'ffffiiiinnnn-sidannnnnn', 'page', 'ffffiiiinnnn sidannnnnn', 'sdflkdj ösldfksöflskdjf sölkdfmsd ölfksjerfölsekrjol', 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 12:20:54', '2015-11-17 12:21:16', '2015-11-17 13:09:35'),
(12, 'doe', 'bamse', 'bamse', 'post', 'bamse', NULL, 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 13:23:21', NULL, '2015-11-17 13:39:13'),
(13, 'doe', 'lille-skutt', 'lille-skutt', 'post', 'lille skutt', NULL, 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 13:24:38', NULL, '2015-11-17 13:36:26'),
(14, 'doe', 'skalman', 'skalman', 'post', 'skalman', NULL, 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 13:26:08', NULL, '2015-11-17 13:34:37'),
(15, 'doe', 'lklklk', 'lklklk', 'post', 'lklklk', NULL, 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 13:28:32', NULL, '2015-11-17 13:33:48'),
(16, 'doe', 'gris', 'gris', 'post', 'gris', NULL, 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 15:08:35', NULL, NULL),
(17, 'doe', 'kulla-gulla', 'kulla-gulla', 'post', 'kulla gulla', NULL, 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 15:17:55', NULL, NULL),
(18, 'doe', 'mulle', 'mulle', 'post', 'mulle', NULL, 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 15:19:59', NULL, NULL),
(19, 'doe', 'fl-sdfl', 'fl-sdfl', 'post', 'flösdflö', NULL, 'nl2br', 'standard-information', '2015-11-17 00:00:00', '2015-11-17 15:24:29', NULL, '2015-11-17 15:24:46'),
(20, 'doe', 'en-ny-postssssstt', 'en-ny-postssssstt', 'post', 'en ny postssssstt', '', '', 'standard-information', '2015-11-18 00:00:00', '2015-11-18 13:10:01', '2015-11-18 13:10:16', '2015-11-18 13:24:02'),
(21, 'doe', 'gurkan-lever', 'gurkan-lever', 'page', 'gurkan lever!', 'Nu är det så att gurkan lever!!!!', '', 'standard-information', '2015-11-18 00:00:00', '2015-11-18 13:23:18', '2015-11-18 13:23:42', '2015-11-18 13:24:17'),
(22, 'doe', 'ppppppp', 'ppppppp', 'post', 'ppppppp', '', 'nl2br', 'standard-information', '2015-11-18 00:00:00', '2015-11-18 13:59:28', '2015-11-18 14:04:50', NULL);

-- --------------------------------------------------------

--
-- Tabellstruktur `genre`
--

CREATE TABLE IF NOT EXISTS `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumpning av Data i tabell `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'okategoriserad'),
(2, 'comedy'),
(3, 'romance'),
(4, 'college'),
(5, 'crime'),
(6, 'drama'),
(7, 'thriller'),
(8, 'animation'),
(9, 'adventure'),
(10, 'family'),
(11, 'svenskt'),
(12, 'action'),
(13, 'horror'),
(14, 'fantasy');

-- --------------------------------------------------------

--
-- Tabellstruktur `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumpning av Data i tabell `images`
--

INSERT INTO `images` (`id`, `image`) VALUES
(1, 'img/movie/pulp-fiction.jpg'),
(2, 'img/movie/pulp-fiction2.jpg'),
(3, 'img/movie/pulp-fiction3.jpg'),
(4, 'img/movie/pulp-fiction4.jpg'),
(5, 'img/movie/pulp-fiction5.jpg'),
(6, 'img/movie/american-pie.jpg'),
(7, 'img/movie/american-pie2.jpg'),
(8, 'img/movie/american-pie3.jpg'),
(9, 'img/movie/american-pie4.jpg'),
(10, 'img/movie/den-grona-milen.jpg'),
(11, 'img/movie/den-grona-milen2.jpg'),
(12, 'img/movie/den-grona-milen3.jpg'),
(13, 'img/movie/forrest-gump.jpg'),
(14, 'img/movie/forrest-gump2.jpg'),
(15, 'img/movie/forrest-gump3.jpg'),
(16, 'img/movie/forrest-gump4.jpg'),
(17, 'img/movie/forrest-gump5.jpg'),
(18, 'img/movie/from-dusk-till-dawn.jpg'),
(19, 'img/movie/from-dusk-till-dawn2.jpg'),
(20, 'img/movie/from-dusk-till-dawn3.jpg'),
(21, 'img/movie/gokboet.jpg'),
(22, 'img/movie/gokboet2.jpg'),
(23, 'img/movie/kopps.jpg'),
(24, 'img/movie/kopps2.jpg'),
(25, 'img/movie/kopps3.jpg'),
(26, 'img/movie/kopps4.jpg'),
(27, 'img/movie/livet-ar-underbart.jpg'),
(28, 'img/movie/livet-ar-underbart2.jpg'),
(29, 'img/movie/livet-ar-underbart3.jpg'),
(30, 'img/movie/nyckeln-till-frihet.jpg'),
(31, 'img/movie/nyckeln-till-frihet2.jpg'),
(32, 'img/movie/nyckeln-till-frihet3.jpg'),
(33, 'img/movie/nyckeln-till-frihet4.jpg'),
(34, 'img/movie/nyckeln-till-frihet5.jpg'),
(35, 'img/movie/nyckeln-till-frihet6.jpg'),
(36, 'img/movie/nyckeln-till-frihet7.jpg'),
(37, 'img/movie/nyckeln-till-frihet8.jpg'),
(38, 'img/movie/nyckeln-till-frihet9.jpg'),
(39, 'img/movie/nyckeln-till-frihet10.jpg'),
(40, 'img/movie/pokemon.jpg'),
(41, 'img/movie/pokemon2.jpg'),
(42, 'img/movie/pokemon3.jpg');

-- --------------------------------------------------------

--
-- Tabellstruktur `movie`
--

CREATE TABLE IF NOT EXISTS `movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `director` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `year` int(11) NOT NULL DEFAULT '1900',
  `plot` text COLLATE utf8_unicode_ci,
  `image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtext` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `speech` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quality` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `format` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rentalprice` int(11) NOT NULL DEFAULT '50',
  `imdblink` text COLLATE utf8_unicode_ci NOT NULL,
  `youtubetrailer` text COLLATE utf8_unicode_ci NOT NULL,
  `creationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumpning av Data i tabell `movie`
--

INSERT INTO `movie` (`id`, `title`, `director`, `length`, `year`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `rentalprice`, `imdblink`, `youtubetrailer`, `creationdate`) VALUES
(1, 'Pulp fiction', 'Quentin Tarantino', 154, 1994, '"Prologue—The Diner"\r\nA couple, Pumpkin and Honey Bunny, decide to rob a diner.\r\nPrelude to "Vincent Vega and Marsellus Wallace''s Wife"\r\nHitmen Jules Winnfield and Vincent Vega are on their way to retrieve a briefcase from Brett, who has transgressed against their boss, gangster Marsellus Wallace. Vincent says Marsellus has asked him to escort his wife while Marsellus is out of town. They arrive at Brett''s place, where they confront him and two of his associates over the briefcase. Vincent finds the briefcase and Jules shoots one of Brett''s associates, then delivers a passage from Bible before executing Brett with Vincent.\r\n"Vincent Vega and Marsellus Wallace''s Wife"\r\nAging champion boxer Butch Coolidge accepts a large sum of money from Marsellus after agreeing to take a dive in his upcoming match. Vincent and Jules arrive to deliver the briefcase. The next day, Vincent drops by the house of Lance to purchase heroin. He shoots up before driving to meet Mrs. Mia Wallace. They head to a 1950s-themed restaurant and participate in a twist contest, then return to the Wallace house with the trophy. While Vincent is in the bathroom, Mia finds his heroin, mistakes it for cocaine, snorts it and overdoses. Vincent rushes her to Lance''s house for help. They administer an adrenaline shot to Mia''s heart, reviving her.\r\nPrelude to "The Gold Watch"\r\nButch recalls a visit from Vietnam veteran Captain Koons in his youth. Koons brought a gold watch passed down through three generations of Coolidge men since World War I; at Coolidge''s father''s dying request, Koons hid the watch in his rectum for two years to deliver it to Butch. The adult Butch prepares for the bout he has agreed to throw.\r\n"The Gold Watch"\r\nButch flees the arena, having double-crossed Marsellus and won the bout. The next morning, at the motel where he and his girlfriend Fabienne are lying low, Butch discovers she has forgotten to pack the irreplaceable watch. He returns to his apartment and retrieves it. He notices a gun on the kitchen counter. Hearing the toilet flush, Butch readies the gun and shoots Vincent dead after he exits the bathroom.\r\nAs Butch waits at a traffic light in his car, Marsellus walks by and recognizes him. Marsellus chases him into a pawnshop. The owner, Maynard, captures them at gunpoint and ties them up in a basement. Maynard is joined by Zed, a security guard; they take Marsellus to another room, leaving a a silent figure in a bondage suit, "the gimp", to watch Butch. Butch breaks loose and knocks out the gimp. He is about to flee, but decides to save Marsellus. As Zed is raping Marsellus, Butch kills Maynard with a katana. Marsellus retrieves Maynard''s shotgun and shoots Zed. Marsellus informs Butch that they are even, so long as he never tells anyone about the rape and departs Los Angeles forever. Butch returns to pick up Fabienne on Zed''s chopper.\r\n"The Bonnie Situation"\r\nAfter Vincent and Jule execute Brett, another man bursts out of the bathroom and shoots wildly, missing every time; Jules and Vincent shoot him. Jules decides their lucky escape was a miracle. As they drive off, Vincent accidentally shoots one of Brett''s associates in the face. Marsellus arranges for the help of his cleaner, Winston Wolfe. Wolfe takes charge of the situation, ordering Jules and Vincent to clean the car, hide the body in the trunk, and dispose of their bloody clothes. They drive the car to a junk yard and Jules and Vincent decide to find a diner.\r\n"Epilogue—The Diner"\r\nIn the diner, Jules tells Vincent he plans to retire from his life of crime. While Vincent is in the bathroom, Pumpkin and Honey Bunny hold up the restaurant. Jules surprises Pumpkin, holding him at gunpoint. Honey Bunny becomes hysterical and trains her gun on Jules, while Vincent emerges from the restroom with his gun trained on her. Jules reprises the biblical passage he recited at Brett''s place. He expresses his ambivalence about his life of crime and allows the robbers to take the cash and leave. Jules and Vincent leave the diner with the briefcase.', 'img/movie/pulp-fiction.jpg', 'SV', 'EN', '10', 'DVD', 35, 'tt0110912', 's7EdQ4FqbhY', '2015-11-30 23:00:00'),
(2, 'American Pie', 'Paul Weitz', 95, 1999, 'Four high school seniors from western Michigan are good friends: Jim Levenstein (Jason Biggs), an awkward, nerdy and sexually naïve character whose dad Noah (Eugene Levy) attempts to offer sexual advice including purchasing and giving him pornography; Chris "Oz" Ostreicher (Chris Klein), a member of the high school lacrosse team; Kevin Myers (Thomas Ian Nicholas), a popular, confident ladies'' man and the leader of the group who loses his virginity to Vicky (Tara Reid); and Paul Finch (Eddie Kaye Thomas), a mochaccino-drinking sophisticate and a nerd. They are four outsiders who are geeks, usually get laughed at by arrogant jock Steve Stifler (Seann William Scott). These four boys make a pact, at Kevin''s prompting, to lose their virginity before their high school graduation after a dorky classmate, Chuck Sherman (Chris Owen), claims to have done so at a party hosted by Stifler.\r\nVicky later accuses Kevin of being with her only for sex, so he must try to repair his relationship with her before the upcoming prom night, when the four plan to lose their virginity. He eventually succeeds. Oz, meanwhile, joins the jazz choir in an attempt to find a girlfriend there. From a college girl he tried to seduce, he learns about sensitivity and how it is about asking girls questions and listening to what they say. He soon wins the attention of Heather (Mena Suvari), a girl in the choir. However, he runs into problems when Heather learns about Oz''s reputation and breaks up with him, although he manages to regain most of her trust when he leaves the lacrosse championship to perform a duet with her in a choir competition.\r\nJim, meanwhile, attempts to pursue Nadia (Shannon Elizabeth), an exchange student from Slovakia who asks Jim for help to study for an upcoming History test. After being told by Oz that third base feels like "warm apple pie", he practices having sex with a pie, only to be caught by Noah (who lets him keep it a secret from his mother). Stifler persuades him to set up a webcam in his room so that they can all watch his encounter with Nadia. The plan suffers a hiccup, though, when Nadia discovers Jim''s pornography collection and sits half-naked on his bed to read and masturbates to it. Jim is persuaded to return to his room, where he joins Nadia, unaware that he accidentally sent the webcam link to everyone on the school list. Nadia is interested in him, but he suffers premature ejaculation twice and is unable to have sex with her. Nadia''s exchange family sees the video and sends her back home, now leaving Jim dateless for the upcoming prom and without hope of losing his virginity before high school is over.\r\nIn sheer desperation, Jim asks band camp geek Michelle Flaherty (Alyson Hannigan) to the senior prom as she is apparently the only girl at his school who did not see what happened. Finch, meanwhile, pays Vicky''s friend, Jessica (Natasha Lyonne), $200 to spread rumors around the school of his sexual prowess, hoping that it will increase his chances of success. Unfortunately, he runs into trouble when Stifler, angry that a girl turned him down for the prom because she was waiting for Finch to ask her, puts a laxative into Finch''s mochaccino. Finch, being paranoid about the lack of cleanliness in the school restrooms, and unable to go home to use the toilet as he usually does, is tricked by Stifler into using the girls'' restroom. Afterward, he emerges humiliated before a crowd of fellow students and is also left dateless.\r\nAt the prom, things seem bleak for the four boys until Vicky asks the girl that Chuck Sherman claimed to have bedded about her "first time." She proclaims to everyone at the prom that she and Sherman did not have sex at Stifler''s party, leaving Sherman embarrassed and making him wet himself. The revelation takes the pressure off of Jim, Kevin, Oz and Finch, and they head to the post-prom party at Stifler''s house with new hope.\r\nAt the after-party, all four boys fulfill their pledges. Kevin and Vicky have sex in an upstairs bedroom. Vicky breaks up with Kevin afterwards on the grounds that they will drift apart when they go to college. Oz confesses the pact to Heather, and renounces it, saying that just by them being together makes him a winner. They reconcile and wind up having sex. Oz, honoring his newfound sensitivity, never confesses to what they did.\r\nJim and Michelle have sex after he finds out that she is actually not as naïve as she let on and that she saw the "Nadia Incident" after all. She accepted his offer to be his date because of it, knowing he was a "sure thing," but she makes him wear two condoms to combat his earlier "problem" with Nadia. Jim is surprised at Michelle''s aggressiveness in bed. In the morning he wakes up to find her gone and realizes that she had used him for a one-night stand, which Jim thinks is "cool".\r\nDateless, Finch strays downstairs to the basement recreation room where he meets Stifler''s Mom (Jennifer Coolidge). She is aroused by his precociousness, and they have sex on the pool table, and Finch has his revenge on Stifler with his mom. The next morning, while Stifler searches for his mom, he finds her on the pool table with Finch, and is so shocked that he faints. The morning after the prom, Jim, Kevin, Oz, and Finch eat breakfast at their favorite restaurant – with the fittingly nostalgic name "Dog Years" – where they toast to "the next step."\r\nFrom Slovakia, Nadia watches Jim stripping on his webcam: Noah walks in (to which Jim is completely oblivious) but happily walks out and also starts dancing.', 'img/movie/american-pie.jpg', 'SV', 'EN', '20', 'DVD', 40, 'tt0163651', 'Sithad108Og', '2015-11-30 23:00:00'),
(3, 'Pokémon The Movie 2000', ' Kunihiko Yuyama', 96, 1999, 'Scientists genetically create a new Pokémon, Mewtwo, but the results are horrific and disastrous.The film begins with an animated short called Pikachu''s Vacation (ピカチュウのなつやすみ Pikachū no Natsuyasumi?, Pikachu''s Summer Vacation) . In the story, the Pokémon of Ash Ketchum, Misty, and Brock are sent to spend a day at a theme park built for Pokémon. Pikachu, Togepi, Bulbasaur, and Squirtle cross paths with a group of bullies consisting of a Raichu, Cubone, Marill, and a Snubbull. The two groups compete against each other in sports, but it leads to Ash’s Charizard getting its head stuck in a pipe. Pikachu, his friends, and the bullies work together and successfully free Charizard, spending the rest of the day playing before parting ways when their trainers return.\r\nThe film begins with a prologue focusing on the origins of Mewtwo. A group of scientists obtain a fossilised eyelash of the legendary Pokémon, Mew, and clone it to create a supersoldier. The lead scientist, Dr. Fuji, is using the project to try to resurrect his deceased daughter Amber. Mewtwo is created, interacting subconsciously with Amber’s clone and those of a Bulbasaur, Charmander, and Squirtle. However, all of the clones die save Mewtwo. He eventually awakens as an adult but upon learning the scientists plan to treat him as a lab rat, he unleashes his psychic powers and destroys the laboratory.\r\nGiovanni, leader of Team Rocket and the project’s benefactor, convinces Mewtwo to work with him to hone his powers. However, after a time, Mewtwo learns his purpose was to be a weapon for Giovanni’s benefit and escapes back to New Island where he plots revenge against humanity. Months later, numerous Pokémon trainers are invited to New Island to meet and battle the world’s greatest Pokémon Master. Amongst them are Ash, Misty, and Brock, but when they arrive at the port city Old Shore Wharf, a powerful storm whips up, preventing the trainers from sailing to the island. However, several trainers use their Pokémon to travel across the sea. Ash’s group are picked up by Team Rocket disguised as Vikings, but the storm sinks their boat, and they individually make it to New Island.\r\nEscorted into the island’s palace by a maid, the trainers encounter Mewtwo, who releases the maid from his mind control, revealed to be a brainwashed Nurse Joy. Mewtwo plots to use the storm to wipe out humanity, leaving only wild and cloned Pokémon alive. Ash challenges Mewtwo’s power, leading to a battle between the trainers’ Pokémon and Mewtwo’s clones who prove to be vastly superior in combat. Mewtwo captures all of the Pokémon to clone them, Ash chasing the captured Pikachu down into the rebuilt lab, where Team Rocket’s Meowth is also cloned. Ash destroys the cloning machine, freeing the Pokémon, and leads them to confront Mewtwo. Mew appears, alive all along, and confronts Mewtwo.\r\nAll of the Pokémon battle save a defiant Pikachu, and Meowth, who makes peace with his own clone. Mew and Mewtwo’s psychic battle wounds all of the Pokémon, forcing a desperate Ash to charge into the firing line of their attacks and is petrified by the blast. Pikachu tries to revive Ash with thunderbolts but it fails. However, the tears of the Pokémon, as per a legend mentioned earlier in the film, are able to heal and revive Ash. Moved by Ash’s sacrifice, Mewtwo realises that he should not have to be judged by his origins but rather his choices in life. Departing with Mew and the clones, Mewtwo erases everyone’s memories of the event.\r\nAsh, Misty, and Brock find themselves back in Old Shore Wharf unsure how they got there. The storm outside clears up, Ash spotting Mew flying through the clouds and tells his friends of how he saw another legendary Pokémon the day he left Pallet Town. Meanwhile, Team Rocket find themselves stranded on New Island but enjoy their time there.', 'img/movie/pokemon.jpg', 'SV', 'EN', '30', 'BLR', 50, 'tt4503906', 'bxTxlKvQFU8', '2015-11-30 23:00:00'),
(4, 'Kopps', 'Josef Fares', 90, 2003, 'When a small town police station is threatened with shutting down because of too little crime, the police realise that something has to be done...The film concerns the police force of a small fictional Swedish village, Högboträsk. The village is so peaceful that crime has become nonexistent. The police spend their shifts drinking coffee, eating hot dogs and chasing down runaway cows. This is all well and good for the village''s own police, but the police management board wants to discontinue the local police force for lack of crime. This would mean the loss of income for the policemen, so they begin to stage crimes in order to preserve their jobs. This includes burning down the local hotdog stand, hiring a drunk to steal a packet of sausages, thrashing a local car, faking a shootout and staging a kidnapping using their friends as actors.', 'img/movie/kopps.jpg', 'SV', 'SV', '40', 'DVD', 30, 'tt0339230', 'aJFdePDqKrY', '2015-11-30 23:00:00'),
(5, 'From Dusk Till Dawn', 'Robert Rodriguez', 108, 1996, 'Two brothers, Seth and Richard "Richie" Gecko, having just robbed a bank, stop at a liquor store to pick up a map. When the arrival of Texas Ranger Earl McGraw threatens their getaway, they kill him and the cashier, burning down the store in the process. During the gunfight, Richie is shot in the hand. Fleeing a combined force of FBI and local police, they head towards Mexico where a contact has arranged a safe-house for them. Along the way they stop at a motel and unload a bank teller whom they are holding hostage. While Seth goes out to "sight see" checking on the border and to buy fast food burgers, Richie brutally rapes and murders the teller. Seth, who pictures himself as a professional thief, becomes furious over Richie''s sadistic behavior.\nMeanwhile, Jacob Fuller, a pastor who is experiencing a crisis of faith, arrives at the same motel with his daughter Kate and his son Scott. The Geckos kidnap the family and order Jacob to take them across the border in his RV. After a tense inspection by a border guard, the group crosses into Mexico. They stop at the "Titty Twister", an isolated strip club and brothel where the Geckos have arranged to meet their contact Carlos at dawn. Seth and Richie beat up the doorman, Chet Pussy, when he tries to deny the group entry.\nAlthough the bartender initially refuses to serve them, he relents after Jacob successfully argues that he is a trucker, but Seth remains annoyed by the disrespect. They take a table, and Seth encourages everyone to drink as the strip show begins. Richie takes special notice of the club''s star performer, Santánico Pandemónium, during an extended solo performance, after which Chet Pussy and some others confront the group. When Richie is stabbed in his already wounded hand, Santánico transforms into a horrific vampire and attacks him, biting him on his neck, which causes him to bleed to death.\nChaos ensues as the employees, the strippers, and the house band all transform. One of the dancers locks the door, and the vampires feed on the bar patrons. Seth, the Fullers, and a few other customers fight back with crosses and wooden stakes until they gain control of the bar-room. When Richie rises as a vampire, Seth reluctantly kills his brother. Seth and the Fullers quickly make an alliance with two other survivors, Sex Machine and Frost. Seth convinces the group that Jacob is their best weapon – if he rediscovers his faith.\nUnknown to the others, Sex Machine has already been bitten, and he transforms as they listen to Frost tell a Vietnam war story; he feeds on both Frost and Jacob. When he is tossed through a boarded up window, a large number of bat-form vampires enter. Seth and the Fullers retreat to a storeroom and improvise anti-vampire weapons from equipment left by past victims. The four stage their final assault on the vampires, their weapons proving effective in destroying many of the creatures. During the battle, Kate kills Sex Machine, and Jacob transforms after he slays the vampiric Frost; however, Scott is hesitant to kill him and gets bitten. After Scott dispatches his father, Kate follows Scott''s wishes and kills both him and his attackers.\nAs the sun rises, only Seth and Kate remain alive, surrounded and low on ammunition. As sunlight breaks through the bullet holes in the bar walls and burns the vampires, Seth tells Kate shoot out more holes, which allows them to survive until Carlos and his guards show up. They blast open the doors, and the sunlight reflects on the bar''s disco ball, killing the rest of the creatures. Seth and Kate flee as the Titty Twister explodes behind them. Safely outside, Seth confronts a bewildered Carlos. Angry over the deaths of Richie, Jacob, and Scott, Seth demands that Carlos lower his 30% take for his stay in El Rey to 15%; Carlos instead lowers his fee to 25%. Kate offers to accompany Seth, but he declines and gives her some cash before they go their separate ways.\nAfter Kate drives the RV away, the camera pans back to reveal that the bar was the top chamber of an Aztec temple, with years of items, namely trucks, from past victims littering its grounds. One can see artifacts from dead conquistadors, too.', 'img/movie/from-dusk-till-dawn.jpg', 'SV', 'EN', '50', 'DVD', 50, 'tt0116367', '-bBay_1dKK8', '2015-11-30 23:00:00'),
(7, 'Nyckeln till frihet ', 'Frank Darabont', 142, 1994, 'In 1947 Portland, Maine, banker Andy Dufresne is convicted of murdering his wife and her lover, and is sentenced to two consecutive life sentences at the fictional Shawshank State Penitentiary in rural Maine. Andy befriends prison contraband smuggler, Ellis "Red" Redding, an inmate serving a life sentence. Red procures a rock hammer and later a large poster of Rita Hayworth for Andy. Working in the prison laundry, Andy is regularly assaulted by the "bull queer" gang "the Sisters" and their leader, Bogs.\r\nIn 1949, Andy overhears the brutal captain of the guards, Byron Hadley, complaining about being taxed on an inheritance, and offers to help him legally shelter the money. After a vicious assault by the Sisters nearly kills Andy, Hadley beats Bogs severely. Bogs is sent to another prison and Andy is never attacked again. Warden Samuel Norton meets Andy and reassigns him to the prison library to assist elderly inmate Brooks Hatlen. Andy''s new job is a pretext for him to begin managing financial matters for the prison employees. As time passes, the Warden begins using Andy to handle matters for a variety of people, including guards from other prisons and the warden himself. Andy begins writing weekly letters to the state government for funds to improve the decaying library.\r\nIn 1954, Brooks is paroled, but cannot adjust to the outside world after 50 years in prison, and hangs himself. Andy receives a library donation that includes a recording of The Marriage of Figaro. He plays an excerpt over the public address system, resulting in him receiving solitary confinement. After his release from solitary, Andy explains that hope is what gets him through his time, a concept that Red dismisses. In 1963, Norton begins exploiting prison labor for public works, profiting by undercutting skilled labor costs and receiving kickbacks. He has Andy launder the money using the alias Randall Stephens.\r\nIn 1965, Tommy Williams is incarcerated for burglary. He joins Andy and Red''s circle of friends, and Andy helps him pass his GED exam. In 1966, Tommy reveals to Red and Andy that an inmate at another prison claimed responsibility for the murders for which Andy was convicted, implying Andy''s innocence. Andy approaches Norton with this information, but the warden refuses to listen and sends Andy back to solitary when he mentions the money laundering. Norton then has Hadley murder Tommy under the guise of an escape attempt. Andy refuses to continue the money laundering, but relents after Norton threatens to burn the library, remove Andy''s protection from the guards, and move him out of his cell into worse conditions. Andy is released from solitary confinement after two months, and tells Red of his dream of living in Zihuatanejo, a Mexican coastal town. Red feels Andy is being unrealistic, but promises Andy that if he is ever released, he will visit a specific hayfield near Buxton, Maine, and retrieve a package Andy buried there. Red becomes worried about Andy''s state of mind, especially when he learns Andy asked another inmate to supply him with six feet of rope.\r\nThe next day at roll call, the guards find Andy''s cell empty. An irate Norton throws a rock at the poster of Raquel Welch hanging on the wall, and the rock tears through the poster. Removing the poster, the warden discovers a tunnel that Andy dug with his rock hammer over the last 17 years, hidden by posters of starlets Andy acquired from Red over the years. The previous night, Andy escaped through the tunnel and used the prison''s sewage pipe to reach freedom, bringing with him Norton''s suit, shoes, and the ledger containing details of the money laundering. While guards search for him the following morning, Andy poses as Randall Stephens and visits several banks to withdraw the laundered money. Finally, he mails the ledger and evidence of the corruption and murders at Shawshank to a local newspaper. The police arrive at Shawshank and take Hadley into custody, while Norton commits suicide to avoid arrest.\r\nAfter serving 40 years, Red is finally paroled. He struggles to adapt to life outside prison and fears he never will. Remembering his promise to Andy, he visits Buxton and finds a cache containing money and a letter asking him to come to Zihuatanejo. Red violates his parole and travels to Fort Hancock, Texas, to cross the border to Mexico, admitting he finally feels hope. On a beach in Zihuatanejo, he finds Andy, and the two friends are happily reunited.', 'img/movie/nyckeln-till-frihet.jpg', 'SV', 'EN', '10', 'DVD', 50, 'tt0111161', 'Ap-oYN3x8xU', '2015-12-02 23:00:00'),
(8, 'Forrest Gump', 'Robert Zemeckis', 142, 1994, 'In 1981, Forrest Gump (Tom Hanks), a man with below-average intelligence, watches a feather fall from the sky at a bus stop in Savannah, Georgia. As he sits down on a bench, he removes a copy of The Adventures of Curious George from his suitcase and places the feather inside the pages. He introduces himself and begins telling his life story to strangers who sit next to him on the bench, recounting his childhood in Greenbow, Alabama. As a child in the 1950s, Forrest (Michael Connor Humphreys) had to wear leg braces for which other children make fun of him. He lives with his single mother (Sally Field) in a very large house outside of town, which they rent rooms to travelers. His father apparently left and he never knew him. Despite his limited mental capacity, Mrs. Gump tells her son that "stupid is as stupid does" (which he later uses as a retort when called "stupid") and also assures him that he is no different from any of the other children. Forrest is admitted to public school despite his IQ being below the cut-off, but only after his mother agrees to a one-night stand with the principal, Mr. Hancock (Sam Anderson). On his first bus ride to school, Forrest is rejected by nearly all of his peers except for Jenny Curran (Hanna R. Hall). He and Jenny become best friends, and he helps her hide from her abusive, alcoholic father. One day, while fleeing from bullies, Forrest''s leg braces break apart and he discovers that he can run very fast. A few years later, Forrest inadvertently runs onto the field during a local high school football match and catches the attention of Coach Bryant from the University of Alabama who is scouting for players. Forrest attends the university on an athletic scholarship and becomes a college football star, earning him a spot on the College Football All-America Team and a trip to the White House to meet President John F. Kennedy.\nAfter graduating, Forrest enlists in the United States Army, where he befriends former shrimp fisherman Benjamin Buford "Bubba" Blue (Mykelti Williamson), and they agree to go into the shrimping business together once they end their service. Jenny (Robin Wright) meanwhile had gotten herself thrown out of college after she exposes herself on the cover of Playboy Magazine and "fulfills" her aspirations of becoming a famous folk singer by performing nude at a strip club. Forrest goes to one of her shows after seeing the cover and intervenes when she is harassed by club patrons. He tells her that his unit is being sent to Vietnam so Jenny tells Forrest that if he is ever in trouble: run. Once they arrive in Vietnam, they are assigned to First Lieutenant Dan Taylor (Gary Sinise). One day while on patrol their platoon is ambushed. Forrest carries several wounded soldiers to safety including Lieutenant Dan and his friend Bubba, but Bubba is severely wounded and dies shortly thereafter. Forrest himself is also wounded in the buttocks and Lieutenant Dan, who has had both of his legs amputated due to his injuries, is furious at Forrest for leaving him a cripple and cheating him out of his destiny to die in battle, as all of his ancestors had. After he recovers from his wounds, Forrest travels to Washington DC where he receives the Medal of Honor from President Lyndon B. Johnson and goes to an anti-war rally where Abbie Hoffman invites him to speak before the crowd. After speaking, Forrest reunites with Jenny, who is now living a hippie counterculture lifestyle with a commune of anti-war activists and has experimented with various substances including LSD.\nForrest discovers an aptitude for ping pong and begins playing for the U.S. Army team, eventually competing against Chinese teams on a goodwill tour. After his return from China, he appears on the The Dick Cavett Show with John Lennon, which after describing his experience in China as best as he can, inspires Lennon to write the song "Imagine". He then encounters Lieutenant Dan, now a wheelchair-bound embittered drunk living on welfare. Dan is scornful of Forrest''s plans to enter the shrimping business and mockingly promises to be Forrest''s first mate if he ever succeeds. Forrest and Lieutenant Dan spend New Years together. He visits the White House again and meets President Richard Nixon, who provides him a room at the Watergate hotel, where Forrest inadvertently helps expose the Watergate scandal.\nForrest is discharged from the military as a sergeant and uses money from a ping pong endorsement to buy a shrimping boat, fulfilling his wartime promise to Bubba. Lieutenant Dan keeps his own promise and joins Forrest as first mate. They initially have little luck, but after Hurricane Carmen wrecks every other shrimping boat in the region, the Bubba Gump Shrimp Company becomes a huge success. Both of them are wealthy. After surviving a storm at sea, Dan finally thanks Forrest for saving his life on the battle field years earlier. Forrest returns home to care for his mother when she becomes terminally ill and passes away. He leaves the company in the hands of Dan, who invests the proceeds of the company in shares of the recently founded Apple Computers, which Forrest assumes is "some kind of fruit company", making them both more wealthy. He gives most of his money to various causes (such as taking care of Bubba''s family) and continues to live in the house where he grew up.\nJenny returns to visit Forrest and stays with him. He proposes but she turns him down. They have sex, but she quietly leaves the next morning. Distraught at discovering this, Forrest decides to go for a run, which turns into a three-year coast-to-coast marathon. Forrest becomes a celebrity, attracting a band of followers. One day he stops his marathon suddenly and returns home, where he receives a letter from Jenny, who had seen him on the news during his running, asking to meet.\nThis brings Forrest to the bus stop where he began telling his story at the start of the film. During his reunion with Jenny, she introduces him to her young son, also named Forrest (Haley Joel Osment). She says that the boy is named for his father, which Forrest assumes is someone else named Forrest until she tells him that he himself is the father. Forrest is initially overwhelmed as he believes that his son also has below-average intelligence, but Jenny assures him that he is a very smart child. Jenny finds out that she is suffering from an unknown illness. She proposes and he accepts, and they return to Alabama with Forrest Jr. and marry. At the wedding, Lieutenant Dan, who now has titanium alloy prosthetic legs and can walk, attends as well as his fiancée.\nEventually, Jenny dies of her illness. Though he misses her terribly, he becomes a devoted father to Forrest Jr. Speaking to Jenny''s tombstone, Forrest tearfully says he does not know if life has a meaning or purpose like Lieutenant Dan said, or if life is entirely random, like his mother said—but he has a feeling that, somehow, "maybe it''s both". The film ends with Forrest waiting for his son to come home from school on the bus after his first day of school, and watching the feather float off in the wind.', 'img/movie/forrest-gump.jpg', 'SV', 'EN', '70', 'DVD', 45, 'tt0109830', 'uPIEn0M8su0', '2015-12-02 23:00:00'),
(9, 'Gökboet ', 'Milos Forman', 133, 1975, 'In 1963 Oregon, Randle Patrick "Mac" McMurphy (Jack Nicholson), a recidivist anti-authoritarian criminal serving a short sentence on a prison farm for the statutory rape of a 15-year-old girl, is transferred to a mental institution for evaluation. Although he does not show any overt signs of mental illness, he hopes to avoid hard labor and serve the rest of his sentence in a more relaxed hospital environment.\nMcMurphy''s ward is run by steely, unyielding Nurse Mildred Ratched (Louise Fletcher), who employs subtle humiliation, unpleasant medical treatments and a mind-numbing daily routine to suppress the patients. McMurphy finds that they are more fearful of Ratched than they are focused on becoming functional in the outside world. McMurphy establishes himself immediately as the leader; his fellow patients include Billy Bibbit (Brad Dourif), a nervous, stuttering young man; Charlie Cheswick (Sydney Lassick), a man disposed to childish fits of temper; Martini (Danny DeVito), who is delusional; Dale Harding (William Redfield), a high-strung, well-educated paranoid; Max Taber (Christopher Lloyd), who is belligerent and profane; Jim Sefelt (William Duell), who is epileptic; and "Chief" Bromden (Will Sampson), a silent Native American of imposing stature who is believed to be deaf and mute.\nMcMurphy''s and Ratched''s battle of wills escalates rapidly. When McMurphy''s card games win away everyone''s cigarettes, Ratched confiscates the cigarettes and rations them out. McMurphy calls for votes on ward policy changes, to watch the World Series, to challenge her. He makes a show of betting the other patients he can escape by lifting an old hydrotherapy console, a massive marble plumbing fixture, off the floor and sending it through the window; but fails to do so.\nMcMurphy steals a hospital bus, herds his colleagues aboard, stops to pick up Candy (Marya Small), a party girl, and takes the group deep sea fishing on a commandeered boat. He tells them: "You''re not nuts; you''re fishermen!" and they begin to feel faint stirrings of self-determination.\nSoon after, however, McMurphy learns that Ratched and the doctors have the power to keep him committed indefinitely. Sensing a rising tide of insurrection among the group, Ratched tightens her grip on everyone. During one of her group therapy sessions, Cheswick''s agitation boils over and he, McMurphy and the Chief wind up brawling with the orderlies. They are sent up to the "shock shop" for electroconvulsive therapy. While McMurphy and the Chief wait their turn, McMurphy offers Chief a piece of gum, and Chief murmurs "Thank you...Ah, Juicy Fruit." McMurphy is delighted to find that Bromden is neither deaf nor mute, and that he stays silent to deflect attention. After the electroshock therapy, McMurphy shuffles back onto the ward feigning brain damage, before humorously animating his face and loudly greeting his fellow patients, assuring everyone that the ECT only charged him up all the more.\nAs the struggle with Ratched takes its toll, and with his release date no longer a certainty, McMurphy plans an escape. He phones Candy to bring her friend Rose (Louisa Moritz) and some booze to the hospital late one night. They enter through a window after McMurphy bribes the night orderly, Mr. Turkle (Scatman Crothers). McMurphy and Candy invite the patients into the day room for a Christmas party; the group breaks into the drug locker, puts on music, and celebrates. At the end of the night, McMurphy and Bromden prepare to climb out the window with the girls. McMurphy says goodbye to everyone, and invites an emotional Billy to escape with them; he declines, saying he is not yet ready to leave the hospital—though he would like to date Candy in the future. McMurphy insists Billy have sex with Candy right then and there. Billy and Candy agree and they retire to a private room. The effects of the alcohol and pilfered medication take their toll on everyone, including McMurphy and the Chief, whose eyes slowly close in fatigue.\nRatched arrives the following morning and discovers the scene: the ward completely upended and patients passed out all over the floor. She orders the attendants to lock the window, clean up, and conduct a head count. When they find Billy and Candy, the other patients applaud and, buoyed, Billy speaks for the first time without a stutter. Ratched then announces that she will tell Billy''s mother what he has done. Billy panics, his stutter returns, he starts punching himself and then locks himself in the doctor''s office. Locked inside, Billy kills himself. McMurphy, enraged at Ratched, chokes her nearly to death until orderly Washington knocks him out.\nSome time later, the patients in the ward play cards and gamble for cigarettes as before, only now with Harding dealing and delivering a pale imitation of McMurphy''s patter. Ratched, still recovering from the neck injury sustained during McMurphy''s attack, wears a neck brace and speaks in a thin, reedy voice. The patients pass a whispered rumor that McMurphy dramatically escaped the hospital rather than being taken "upstairs".\nLate that night, Bromden sees McMurphy being escorted back to his bed, and initially believes that he has returned so they can escape together, which he is now ready to do since McMurphy has made him feel "as big as a mountain". However, when he looks closely at McMurphy''s unresponsive face, he is horrified to see lobotomy scars on his forehead. Unwilling to allow McMurphy to live in such a state, the Chief smothers McMurphy to death with his pillow. He then carries out McMurphy''s escape plan by lifting the hydrotherapy console off the floor and hurling the massive fixture through a grated window. Chief climbs through the window and runs off into the distance, with Taber waking up just in time to see him escape and cheering as the others awake.', 'img/movie/gokboet.jpg', 'SV', 'EN', '80', 'VHS', 50, 'tt0073486', 'NN1cCviBXmY', '2015-12-02 23:00:00'),
(10, 'Den gröna milen', 'Frank Darabont', 189, 1999, 'In a Louisiana nursing home in 1999, Paul Edgecomb becomes nervous while watching the 1935 film Top Hat. He is with his elderly friend Elaine, who becomes concerned, and Paul tells her that the film reminded him of his past, when he was a prison officer in charge of death row inmates at the Cold Mountain Penitentiary during the summer of 1935.\r\nThe scene shifts to 1935, where Paul works with fellow guards Brutus "Brutal" Howell, Harry Terwilliger, and Dean Stanton. One day, John Coffey, an African-American man convicted of raping and killing two young white girls, arrives in the prison. John is very shy, soft-spoken, and a very emotional person, in stark contrast to the crime he was convicted of. John reveals extraordinary powers by healing Paul''s bladder infection and resurrecting Mr. Jingles, a pet mouse kept by inmate Eduard "Del" Delacroix, only by his touch. Later, he heals the terminally ill wife of Warden Hal Moores. When John is asked to explain his power, he merely says that he "took it back."\r\nPercy Wetmore, a sadist with a fierce temper, begins working in the death row inmates block; his fellow guards dislike him, but cannot get rid of him due to his family connections to the governor. Meanwhile, a psychopathic prisoner named "Wild Bill" Wharton is booked into the jail for multiple murders committed during a robbery. At one point Wharton seizes John''s arm, and John psychically senses that Wharton is also responsible for the crime for which John was wrongly convicted.\r\nAfter Percy scares Del, Wharton seizes him onto the cell bars. Percy is shocked and urinates himself, which Del finds amusing. Paul coerces Wharton to let Percy go. Percy offers that he will transfer to an administrative post at a mental hospital in exchange for managing Del''s upcoming execution. However, Percy uses the opportunity to punish Del by failing to wet down the conductive sponge used on the electric chair. When the electricity is turned on, Del''s body bursts into flames. Later, John regurgitates the sickness from Hal''s wife into Percy; Percy becomes unable to talk and shoots Wharton to death and falls into a permanent state of catatonia, and is admitted as a patient to the mental hospital.\r\nIn wake of the events, Paul interrogates John on what happened. John says he "punished them bad men" and offers to show Paul what he saw by giving him a "part of himself". Paul takes John''s hand, and sees what John had seen from Wharton, that Wharton was responsible for the crime. Paul offers to let John go, but John refuses, saying that there is too much pain in the world and he is "rightly tired" of it. John patiently awaits the date of execution, and as part of his last request, enjoys the film Top Hat on the night prior. When John is put on the electric chair, Paul honors a final request, not to put the hood over John''s head as he is afraid of the dark. Paul shakes John''s hand, and watches as the execution is completed.\r\nAs an elderly Paul finishes his story, he notes that he spent the remainder of his career at a youth detention center. He reveals to Elaine that he is over 108 years old, which he believes came from the "part of himself" John had given him; he also reveals the mouse, Mr. Jingles, is also still alive. Paul believes it to be a punishment from God for having let John be executed, as he has outlasted all of his friends and family and unsure of when he will die. The film ends on glimpses of a future where Elaine has died and Paul remains alone at the retirement home.In a Louisiana nursing home in 1999, Paul Edgecomb becomes nervous while watching the 1935 film Top Hat. He is with his elderly friend Elaine, who becomes concerned, and Paul tells her that the film reminded him of his past, when he was a prison officer in charge of death row inmates at the Cold Mountain Penitentiary during the summer of 1935.\r\nThe scene shifts to 1935, where Paul works with fellow guards Brutus "Brutal" Howell, Harry Terwilliger, and Dean Stanton. One day, John Coffey, an African-American man convicted of raping and killing two young white girls, arrives in the prison. John is very shy, soft-spoken, and a very emotional person, in stark contrast to the crime he was convicted of. John reveals extraordinary powers by healing Paul''s bladder infection and resurrecting Mr. Jingles, a pet mouse kept by inmate Eduard "Del" Delacroix, only by his touch. Later, he heals the terminally ill wife of Warden Hal Moores. When John is asked to explain his power, he merely says that he "took it back."\r\nPercy Wetmore, a sadist with a fierce temper, begins working in the death row inmates block; his fellow guards dislike him, but cannot get rid of him due to his family connections to the governor. Meanwhile, a psychopathic prisoner named "Wild Bill" Wharton is booked into the jail for multiple murders committed during a robbery. At one point Wharton seizes John''s arm, and John psychically senses that Wharton is also responsible for the crime for which John was wrongly convicted.\r\nAfter Percy scares Del, Wharton seizes him onto the cell bars. Percy is shocked and urinates himself, which Del finds amusing. Paul coerces Wharton to let Percy go. Percy offers that he will transfer to an administrative post at a mental hospital in exchange for managing Del''s upcoming execution. However, Percy uses the opportunity to punish Del by failing to wet down the conductive sponge used on the electric chair. When the electricity is turned on, Del''s body bursts into flames. Later, John regurgitates the sickness from Hal''s wife into Percy; Percy becomes unable to talk and shoots Wharton to death and falls into a permanent state of catatonia, and is admitted as a patient to the mental hospital.\r\nIn wake of the events, Paul interrogates John on what happened. John says he "punished them bad men" and offers to show Paul what he saw by giving him a "part of himself". Paul takes John''s hand, and sees what John had seen from Wharton, that Wharton was responsible for the crime. Paul offers to let John go, but John refuses, saying that there is too much pain in the world and he is "rightly tired" of it. John patiently awaits the date of execution, and as part of his last request, enjoys the film Top Hat on the night prior. When John is put on the electric chair, Paul honors a final request, not to put the hood over John''s head as he is afraid of the dark. Paul shakes John''s hand, and watches as the execution is completed.\r\nAs an elderly Paul finishes his story, he notes that he spent the remainder of his career at a youth detention center. He reveals to Elaine that he is over 108 years old, which he believes came from the "part of himself" John had given him; he also reveals the mouse, Mr. Jingles, is also still alive. Paul believes it to be a punishment from God for having let John be executed, as he has outlasted all of his friends and family and unsure of when he will die. The film ends on glimpses of a future where Elaine has died and Paul remains alone at the retirement home.', 'img/movie/den-grona-milen.jpg', 'SV', 'EN', '90', 'DVD', 50, 'tt0120689', 'ctRK-4Vt7dA', '2015-12-02 23:00:00');
INSERT INTO `movie` (`id`, `title`, `director`, `length`, `year`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `rentalprice`, `imdblink`, `youtubetrailer`, `creationdate`) VALUES
(11, 'Livet är underbart', 'Roberto Benigni', 116, 1997, 'When an open-minded Jewish librarian and his son become victims of the Holocaust, he uses a perfect mixture of will, humor and imagination to protect his son from the dangers around their camp.In 1939 Italy, Guido Orefice is a young Jewish man who is leaving his old life and going to work in the city where his uncle lives. Guido is comical and sharp, making the best from each situation he encounters. From the start he falls in love with a girl Dora. Later he sees her again in the city where she is a teacher. Dora is set to be engaged to a rich but arrogant man. He is a local government official with whom Guido has run-ins from the beginning. Guido is still in love with Dora and performs many stunts in order to see her. Guido sets up many "coincidental" incidents to show his interest. Finally Dora sees Guido''s affection and promise and gives in against her better judgement. He steals her from her engagement party on a horse, humiliating her fiancé and mother. Soon they are married and have a son, Giosuè.\r\nThrough the first part, the film depicts the changing political climate in Italy: Guido frequently imitates members of the National Fascist Party, skewering their racist logic and pseudoscientific reasoning (at one point, jumping onto a table to demonstrate his "perfect Aryan bellybutton"). However, the growing Fascist wave is also evident: the horse Guido steals Dora away on has been painted green and covered in antisemitic insults. Later during World War II, after Dora and her mother have reconciled, Guido, his Uncle Eliseo and Giosuè are seized on Giosuè''s birthday. They and many other Jews are forced onto a train and taken to a concentration camp. After confronting a guard about her husband and son and being told there is no mistake, Dora volunteers to get on the train in order to be close to her family. However, as men and women are separated in the camp, Dora and Guido never see each other during the internment. Thus, Guido pulls off stunts, such as using the camp''s loudspeaker, to send messages, symbolic or literal, to Dora to assure her that he and their son are safe. Eliseo is executed in a gas chamber shortly after their arrival. Giosuè barely avoids being gassed himself as he hates to take baths and showers, and did not follow the other children when they had been ordered to enter the gas chambers.\r\nIn the camp, Guido hides their true situation from his son. Guido explains to Giosuè that the camp is a complicated game in which he must perform the tasks Guido gives him. Giosuè is at times reluctant to go along with the game, but Guido convinces him each time to continue on. Guido sets up the concentration camp as a game for Giosuè. Each of the tasks will earn them points and whoever gets to one thousand points first will win a tank. He tells him that if he cries, complains that he wants his mother, or says that he is hungry, he will lose points, while quiet boys who hide from the camp guards earn extra points. Guido uses this game to explain features of the concentration camp that would otherwise be frightening for a young child: the guards are mean only because they want the tank for themselves; the dwindling numbers of children (who are being killed in gas chambers) are only hiding in order to score more points than Giosuè so they can win the game. He puts off Giosuè''s requests to end the game and return home by convincing him that they are in the lead for the tank, and need only wait a short while before they can return home with their tank. Guido eventually buys additional time by intentionally getting Giosuè mixed in with nearby German schoolchildren, and briefly working as a servant for the same kids in order to help keep the other officials from noticing that Giosuè is actually Italian.\r\nDespite being surrounded by the misery, sickness, and death at the camp, Giosuè does not question this fiction because of his father''s convincing performance and his own innocence. Guido maintains this story right until the end when, in the chaos of shutting down the camp as the Allied forces approach, he tells his son to stay in a sweatbox until everybody has left, this being the final competition before the tank is his. As the camp is in chaos Guido goes off to find Dora, but while he is out he is caught by a German soldier. An officer makes the decision to execute Guido. Guido is led off by the soldier to be executed. While he is walking to his death, Guido passes by Giosuè one last time, still in character and playing the game. The next morning, Giosuè emerges from the sweatbox, just as a U.S. Army unit led by a Sherman tank arrives and the camp is liberated. Giosuè is elated and is convinced he has won the game and the prize. The captives in the concentration camp also emerge from hiding. The prisoners travel to safety, accompanied by the Americans. While they are traveling, the soldiers allow Giosuè to ride on the tank with them. Giosuè soon spots Dora in the procession leaving the camp. Giosuè and Dora are reunited and are extremely happy to see each other. In the film, Giosuè is a young boy; however, both the beginning and ending of the film are narrated by an older Giosuè recalling his father''s story of sacrifice for his family.', 'img/movie/livet-ar-underbart.jpg', 'SV', 'IT', '100', 'DVD', 20, 'tt0118799', 'ZARpRCVFNuU', '2015-12-02 23:00:00'),
(14, 'Ant man', 'Peyton Reed', 117, 2015, 'Ant-Man is a 2015 American superhero film based on the Marvel Comics characters of the same name: Scott Lang and Hank Pym. Produced by Marvel Studios and distributed by Walt Disney Studios Motion Pictures, it is the twelfth installment of the Marvel Cinematic Universe (MCU). The film was directed by Peyton Reed, with a screenplay by Edgar Wright & Joe Cornish and Adam McKay & Paul Rudd, and stars Rudd, Evangeline Lilly, Corey Stoll, Bobby Cannavale, Michael Peña, Tip "T.I." Harris, Anthony Mackie, Wood Harris, Judy Greer, David Dastmalchian, and Michael Douglas. In Ant-Man, Lang must help defend Dr. Pym''s Ant-Man shrinking technology and plot a heist with worldwide ramifications.\r\nDevelopment of Ant-Man began in April 2006, with the hiring of Wright to direct and co-write with Cornish. By April 2011, Wright and Cornish had completed three drafts of the script and Wright shot test footage for the film in July 2012. Pre-production began in October 2013 after being put on hold so that Wright could complete The World''s End. Casting began in December 2013, with the hiring of Rudd to play Lang. In May 2014, Wright left the project, citing creative differences, though he still received screenplay and story credits with Cornish, as well as an executive producer credit. The following month, Reed was brought in as Wright''s replacement, while McKay was hired to contribute to the script with Rudd. Principal photography took place between August and December 2014 in San Francisco and Metro Atlanta.\r\nAnt-Man held its world premiere in Los Angeles on June 29, 2015, and was released in North America on July 17, 2015, in 3D and IMAX 3D. Upon its release, the film received positive reviews and has grossed more than $518 million worldwide. A sequel, titled Ant-Man and the Wasp, is scheduled to be released on July 6, 2018.', NULL, 'SV', 'EN', '100', 'BLR', 50, 'tt0478970', 'QfOZWGLT1JM', '2015-12-08 09:51:37'),
(15, 'kkkkkkkkkkkkk', '', 0, 0, '', NULL, 'SV', 'SV', '10', 'DVD', 50, '', '', '2015-12-08 09:56:27'),
(16, 'Kolli koll koll', 'Urban', 1243, 15, 'sdlfks lmkdlfksmlermslkrm lerkmelrkmslrkemrslekrmlkm', NULL, 'IT', 'EN', '100', 'VHS', 50, '', '', '2015-12-12 10:48:49');

-- --------------------------------------------------------

--
-- Tabellstruktur `movie2genre`
--

CREATE TABLE IF NOT EXISTS `movie2genre` (
  `idMovie` int(11) NOT NULL,
  `idGenre` int(11) NOT NULL,
  PRIMARY KEY (`idMovie`,`idGenre`),
  KEY `idGenre` (`idGenre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `movie2genre`
--

INSERT INTO `movie2genre` (`idMovie`, `idGenre`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(14, 1),
(15, 2),
(15, 3),
(16, 7);

-- --------------------------------------------------------

--
-- Tabellstruktur `movie2image`
--

CREATE TABLE IF NOT EXISTS `movie2image` (
  `movie_id` int(11) NOT NULL,
  `image_id` bigint(20) unsigned NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `movie_id` (`movie_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumpning av Data i tabell `movie2image`
--

INSERT INTO `movie2image` (`movie_id`, `image_id`, `id`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(1, 4, 4),
(1, 5, 5),
(2, 6, 6),
(2, 7, 7),
(2, 8, 8),
(2, 9, 9),
(10, 10, 10),
(10, 11, 11),
(10, 12, 12),
(8, 13, 13),
(8, 14, 14),
(8, 15, 15),
(8, 16, 16),
(8, 17, 17),
(5, 18, 18),
(5, 19, 19),
(5, 20, 20),
(9, 21, 21),
(9, 22, 22),
(4, 23, 23),
(4, 24, 24),
(4, 25, 25),
(4, 26, 26),
(11, 27, 27),
(11, 28, 28),
(11, 29, 29),
(7, 30, 30),
(7, 31, 31),
(7, 32, 32),
(7, 33, 33),
(7, 34, 34),
(7, 35, 35),
(7, 36, 36),
(7, 37, 37),
(7, 38, 38),
(7, 39, 39),
(3, 40, 40),
(3, 41, 41),
(3, 42, 42);

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acronym` char(12) NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `salt` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acronym` (`acronym`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`id`, `acronym`, `name`, `password`, `salt`) VALUES
(1, 'doe', 'John/Jane Doe', 'dce47d18bea0027b317b7151130669f2', 1448526642),
(2, 'admin', 'Administrator', '087f18a5a17237ef49c675a54e4a01e8', 1448526642);

-- --------------------------------------------------------

--
-- Ersättningsstruktur för vy `vmovie`
--
CREATE TABLE IF NOT EXISTS `vmovie` (
`id` int(11)
,`title` varchar(100)
,`director` varchar(100)
,`length` int(11)
,`year` int(11)
,`plot` text
,`image` varchar(100)
,`subtext` char(3)
,`speech` char(3)
,`quality` char(3)
,`format` char(3)
,`genre` text
);
-- --------------------------------------------------------

--
-- Struktur för vy `vmovie`
--
DROP TABLE IF EXISTS `vmovie`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vmovie` AS select `m`.`id` AS `id`,`m`.`title` AS `title`,`m`.`director` AS `director`,`m`.`length` AS `length`,`m`.`year` AS `year`,`m`.`plot` AS `plot`,`m`.`image` AS `image`,`m`.`subtext` AS `subtext`,`m`.`speech` AS `speech`,`m`.`quality` AS `quality`,`m`.`format` AS `format`,group_concat(`g`.`name` separator ',') AS `genre` from ((`movie` `m` left join `movie2genre` `m2g` on((`m`.`id` = `m2g`.`idMovie`))) left join `genre` `g` on((`m2g`.`idGenre` = `g`.`id`))) group by `m`.`id`;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `movie2genre`
--
ALTER TABLE `movie2genre`
  ADD CONSTRAINT `movie2genre_ibfk_1` FOREIGN KEY (`idMovie`) REFERENCES `movie` (`id`),
  ADD CONSTRAINT `movie2genre_ibfk_2` FOREIGN KEY (`idGenre`) REFERENCES `genre` (`id`);

--
-- Restriktioner för tabell `movie2image`
--
ALTER TABLE `movie2image`
  ADD CONSTRAINT `movie2image_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`),
  ADD CONSTRAINT `movie2image_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
