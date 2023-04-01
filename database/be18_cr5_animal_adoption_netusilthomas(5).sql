-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 01. Apr 2023 um 15:08
-- Server-Version: 10.4.27-MariaDB
-- PHP-Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `be18_cr5_animal_adoption_netusilthomas`
--
CREATE DATABASE IF NOT EXISTS `be18_cr5_animal_adoption_netusilthomas` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `be18_cr5_animal_adoption_netusilthomas`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_line_1` varchar(255) NOT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `house_number` varchar(20) NOT NULL,
  `stair` varchar(20) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state_province_region` varchar(255) DEFAULT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(255) NOT NULL,
  `address_type` enum('office','private') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `address_line_1`, `address_line_2`, `house_number`, `stair`, `city`, `state_province_region`, `postal_code`, `country`, `address_type`) VALUES
(1, 1, 'Kagraner Anger', NULL, '22', '1', 'Wien', 'Wien', '1220', 'Austria', 'private');

-- --------------------------------------------------------

--- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `animal`
--

CREATE TABLE `animal` (
  `id` int(11) NOT NULL,
  `animal_name` varchar(64) NOT NULL,
  `breed` varchar(32) NOT NULL,
  `age` int(2) NOT NULL,
  `short_description` text NOT NULL,
  `animal_type` enum('small','large') NOT NULL DEFAULT 'small',
  `picture` varchar(64) NOT NULL DEFAULT 'product.png',
  `vaccines` varchar(50) NOT NULL,
  `adopted_from` int(5) NOT NULL,
  `adoption_date` date NOT NULL DEFAULT current_timestamp(),
  `available` enum('no','yes') NOT NULL DEFAULT 'yes',
  `fk_created_by_user` int(11) NOT NULL,
  `animal_last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` enum('no','yes') DEFAULT 'no',
  `lives_in` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `animal`
--

INSERT INTO `animal` (`id`, `animal_name`, `breed`, `age`, `short_description`, `animal_type`, `picture`, `vaccines`, `adopted_from`, `adoption_date`, `available`, `fk_created_by_user`, `animal_last_modified`, `deleted`, `lives_in`) VALUES
(13, 'Pengi', 'African Black-footed Penguin', 2, 'HABITAT Rocky ocean coasts\r\nDIET Fish, including sardines and anchovies, as well as squid and crustaceans\r\nTHREATS Habitat loss, overfishing, coastal development\r\nINTERESTING FACTS The African penguin is the only penguin species breeding on the African continent.', 'small', 'avatar.png', 'H5n1', 0, '0000-00-00', 'yes', 1, '2023-04-01 12:31:25', 'no', 'schönbrunn'),
(14, 'Pengi', 'African Black-footed Penguin', 25, 'HABITAT Rocky ocean coasts\r\nDIET Fish, including sardines and anchovies, as well as squid and crustaceans\r\nTHREATS Habitat loss, overfishing, coastal development\r\nINTERESTING FACTS The African penguin is the only penguin species breeding on the African continent.', 'small', '641e8a39c5d08.jpg', 'H5n1', 0, '0000-00-00', 'yes', 1, '2023-04-01 12:31:32', 'no', 'Schönbrunn'),
(15, 'Atlas', 'African Rhino', 15, 'HABITAT Tropical and subtropical grasslands, savannas, and shrublands; tropical moist forests; deserts\r\nDIET Megaherbivores—plants\r\nTHREATS Poaching for the illegal wildlife trade, habitat loss\r\nINTERESTING FACTS African rhinos are divided into two species— the black rhino and the white rhino. As megaherbivores—planteaters that weigh more than 2,000 pounds—they maintain the diverse African grasslands and woodlands on which countless other species depend.', 'large', '641e8e1f9f0b9.jpg', 'anti-rabies', 6, '2015-04-10', 'no', 1, '2023-04-01 12:31:43', 'no', 'Hellbrunn'),
(16, 'Painted Wolf', 'African Wild Dog', 6, 'HABITAT Forests, grasslands, deserts\r\nDIET Ruminants, such as gazelles\r\nTHREATS Habitat loss, disease, human-wildlife conflict\r\nINTERESTING FACTS African wild dog pups are cared for and raised by the entire pack.', 'small', '641e8c5df0907.jpg', 'rabies', 0, '0000-00-00', 'yes', 1, '2023-04-01 12:32:12', 'no', 'Bronce Zoo'),
(17, 'Willy', 'Beluga Whale', 6, 'HABITAT Arctic Ocean and its nearby seas in the Northern Hemisphere\r\nDIET A variety of fish species, such as salmon and herring, as well as shrimp, crabs, and mollusks\r\nTHREATS Climate change, industrial development\r\nINTERESTING FACTS Like the closely related narwhal, beluga whales lack a dorsal fin, an adaptation that helps them conserve heat in their Arctic home.', 'large', '641e9a408c6db.webp', 'none', 0, '0000-00-00', 'yes', 1, '2023-04-01 12:33:45', 'no', 'Toronto Zoo'),
(18, 'Daffy', 'Cheetah', 16, 'HABITAT Savannas and grasslands of sub-Saharan Africa\r\nDIET Ungulates (hoofed animals) such as gazelles, impalas, and wildebeest calves\r\nTHREATS Hunting, habitat loss, and the decline of prey species\r\nINTERESTING FACTS Cheetah mothers raise their young in isolation. They move their litter—usually two to six cubs—every four days to prevent a buildup of scent that predators can track.', 'large', '641e9b9979ae5.jpg', 'anti-rabies', 3, '2010-01-15', 'no', 1, '2023-04-01 12:33:34', 'no', 'Welsh Mountain Zoo'),
(19, 'Kaa', 'Cobra', 1, 'HABITAT Forests, swamps\nDIET Mammals, lizards, and birds\nTHREATS Deforestation, habitat loss\nINTERESTING FACTS When confronted, the king cobra—one of the most venomous snakes on Earth—can “stand up” and look a full-grown person in the eye. Fortunately, cobras are shy and avoid humans when possible. The amount of poison in a single bite is enough to kill 20 people or even an elephant.', 'small', '641e960da4f63.jpg', 'none', 3, '2022-10-12', 'no', 1, '2023-04-01 12:34:02', 'no', 'Australia Zoo'),
(20, 'Cocquina', 'Fennec Fox', 5, 'HABITAT North Africa to North Sinai\r\nDIET Primarily grasshoppers and locusts but also other insects, rodents, birds, lizards, and roots\r\nTHREATS Trapping for the commercial trade\r\nINTERESTING FACTS The fennec fox’s ears allow for excellent hearing, its primary sense for hunting.', 'small', '641e92946bc87.webp', 'anti-rabies', 5, '2018-08-21', 'no', 1, '2023-04-01 12:34:36', 'no', 'Philadelphia Zoo'),
(21, 'Bubbles', 'Flamingo', 13, 'HABITAT Shallow saltwater or brackish waters\r\nDIET Algae, shrimp\r\nTHREATS Habitat loss\r\nINTERESTING FACTS Flamingos’ unique bills help them feed by plunging their heads into the water upside-down and filtering the water for shrimp, which in turn gives the flamingo its bright pink color.', 'large', '641e93eb1decb.webp', 'H5n1', 0, '0000-00-00', 'yes', 1, '2023-04-01 12:34:45', 'no', '    Yokohame Zoo'),
(22, 'Bubbles', 'Gorilla Infant', 1, 'HABITAT Forests\r\nDIET Stems, bamboo shoots, fruits; western lowland gorillas also eat ants and termites\r\nTHREATS Poaching, disease, habitat loss\r\nINTERESTING FACTS Gorillas, the largest living primates, function in a well-developed social structure and often exhibit behavior and emotions similar to human’s, including laughter and sadness. Females give birth to one baby every four to six years and nurture their young for several years. This slow population growth makes it harder for gorillas to recover from any population decline.', 'large', '641e997d0fe9f.jpg', 'none', 6, '2023-02-14', 'no', 1, '2023-04-01 12:35:11', 'no', 'Zoo Zürich'),
(23, 'Pezz', 'Grizzly Bear', 45, 'HABITAT Forests, mountains, polar regions\r\nDIET Omnivorous (changes with the seasons)—fleshy roots, fruits, berries, grasses; fish (especially salmon); rodents like ground squirrels; carrion; and hoofed animals like moose, elk, caribou, and deer\r\nTHREATS Habitat loss, hunting\r\nINTERESTING FACTS Grizzly bears are so named because their brown fur can be tipped with white, giving them a “grizzled” look.', 'large', '641e960da4f63.webp', 'ABLV', 0, '0000-00-00', 'yes', 1, '2023-04-01 12:35:30', 'no', 'Edinburgh Zoo'),
(24, 'Dotty', 'Ladybug', 1, 'HABITAT Grasslands, forests, along rivers\r\nDIET Aphids and other insects\r\nTHREATS Climate change, habitat loss\r\nINTERESTING FACTS Ladybugs’ bright coloring is a warning to predators—when threatened, they secrete a foul-smelling substance from their legs, and they also play dead. Ladybugs hibernate in large groups and awaken when the temperature warms to 55 degrees, signaling that food is available.', 'small', '641e793575298.webp', 'none', 0, '0000-00-00', 'yes', 1, '2023-04-01 12:35:49', 'no', 'San Diego Zoo'),
(25, 'Dracula', 'Flying Fox', 3, 'HABITAT Forests\r\nDIET Nectar, pollen, fruit\r\nTHREATS Habitat loss\r\nINTERESTING FACTS Dipping their heads into flowering plants, flying foxes use their long tongues to extract pollen and nectar. The pollen that inadvertently collects on their fur is then transferred to the next flowers they visit.', 'small', '641e97ed208bf.webp', 'ABLV', 6, '2020-12-24', 'no', 1, '2023-04-01 12:35:52', 'no', 'Zoo Basel');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `communication`
--

CREATE TABLE `communication` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `communication_type_id` enum('www','eMail (private)','eMail (office)','mobile (private)','mobile (office)','fax (private)','fax (office)','telephone (private)','telephone (office)','telephone no','mobile no','fax no','email address') DEFAULT 'eMail (private)',
  `communication_number` varchar(50) DEFAULT NULL,
  `communication_remarks` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `communication`
--

INSERT INTO `communication` (`id`, `user_id`, `communication_type_id`, `communication_number`, `communication_remarks`) VALUES
(1, 1, 'eMail (private)', 'thomas.netusil@gmail.com', NULL),
(2, 1, 'mobile (private)', '+43 677 62909881', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `user_id` int(5) NOT NULL,
  `username` varchar(35) NOT NULL,
  `firstname` varchar(35) NOT NULL,
  `lastname` varchar(55) NOT NULL,
  `fk_adress` int(11) NOT NULL,
  `fk_user_communication` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('admin','user') NOT NULL DEFAULT 'user',
  `user_language` enum('de','en') NOT NULL DEFAULT 'en',
  `UserSession` varchar(32) DEFAULT NULL,
  `user_last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_modified_from` int(11) NOT NULL,
  `deleted` enum('no','yes') DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`user_id`, `username`, `firstname`, `lastname`, `fk_adress`, `fk_user_communication`, `password`, `date_of_birth`, `image`, `status`, `user_language`, `UserSession`, `user_last_modified`, `user_modified_from`, `deleted`) VALUES
(1, 'admin', 'Thomas', 'Netusil', 0, 0, '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1967-04-30', '', 'admin', 'de', NULL, '2023-03-30 12:43:05', 0, 'no'),
(3, 'thomas@ariadne.at', 'Thomas', 'Netusil', 0, 0, '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1967-04-30', '6427f3c8c114b.jpg', 'user', 'en', '', '2023-04-01 12:00:04', 0, 'no'),
(4, 'admin@ariadne.at', 'Thomas', 'Netusil', 0, 0, '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1967-04-30', 'avatar.png', 'admin', 'en', '', '2023-03-30 12:45:08', 0, 'no'),
(5, 'vilma@ariadne.at', 'Vilma', 'Netusil', 0, 0, '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1944-02-07', '6427e8850762c.webp', 'user', 'en', '', '2023-04-01 08:17:09', 0, 'no'),
(6, 'alexander@ariadne.at', 'Alexander', 'Netusil', 0, 0, '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1968-10-25', '6427e75e4bb36.jpg', 'user', 'en', '', '2023-04-01 08:12:14', 0, 'no');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_created_by_user` (`fk_created_by_user`),
  ADD KEY `adopted_from` (`adopted_from`);

--
-- Indizes für die Tabelle `communication`
--
ALTER TABLE `communication`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_user_communication` (`user_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `fk_adress` (`fk_adress`),
  ADD KEY `fk_user_communication` (`fk_user_communication`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `animal`
--
ALTER TABLE `animal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT für Tabelle `communication`
--
ALTER TABLE `communication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `fk_created_by_user` FOREIGN KEY (`fk_created_by_user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `communication`
--
ALTER TABLE `communication`
  ADD CONSTRAINT `fk_user_communication` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
