-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 29 Paź 2021, 15:13
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `shop`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `zipcode` char(6) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `phoneNumber` char(12) DEFAULT NULL,
  `nip` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `addresses`
--

INSERT INTO `addresses` (`id`, `userId`, `firstName`, `lastName`, `zipcode`, `city`, `address`, `phoneNumber`, `nip`) VALUES
(6, 6, 'Marcin', 'Nowak', '02-242', 'Warszawa', 'Aleje 53', '222-222-201', '563147312'),
(7, 6, 'Andrzej', 'Nowak', '42-124', 'Lublin', 'Nadbystrzycka 39', '444-444-444', ''),
(8, 4, 'Sebastian', 'Guzik', 'Test 1', '21-512', 'Warszawa', '512-512-5', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `visable` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `price`, `visable`) VALUES
(1, 'HP Pavilion 15 Ryzen 5-4500/16GB/512/Win10 Silver', 'Uniwersalny laptop HP Pavilion 15 \r\nPoznaj HP Pavilion 15. Wyjątkową serię laptop&oacute;w, kt&oacute;ra sprosta Twoim wszelkim oczekiwaniom. Nowoczesny procesor AMD Radeon&trade; oraz zintegrowany układ graficzny nigdy Cię nie zawiodą. To uniwersalne urządzenie sprawdzi się, gdy będziesz używać go do pracy w biurze lub zapragniesz zrelaksować się w domu przy multimediach, czy grze. Wszystko to obejrzysz na wysokiej klasy matowym ekranie w technologii IPS oraz w rozdzielczości Full HD. Zostań szczęśliwym posiadaczem laptopa HP Pavilion 15.\r\n\r\nProcesor AMD Radeon&trade; 5\r\nZyskaj moc, wydajność, szybkość i responsywność, kt&oacute;re zapewni Ci procesor AMD Radeon&trade; 5. Zaawansowana jednostka zarządzana autorską architekturą AMD Zen. Przygotuj się na znakomitą płynność obsługi zadań, jaką procesor osiąga dzięki funkcji rezerwowania zasob&oacute;w CPU. Teraz możesz grać w popularne gry, swobodnie strumieniować multimedia oraz pracować z wymagającymi programami.\r\n\r\nOsiągnij więcej\r\nWs', '2999.00', 1),
(6, 'test przedmiot 2 nie widoczny', 'opis przedmiotu 2', '10.00', 0),
(12, 'SteelSeries Rival 3', 'Mysz dla graczy SteelSeries Rival 3\r\nNajnowsza mysz Rival 3 od firmy SteelSeries to następca legendarnej myszki Rival 110. Oznacza to, że jest jeszcze lepsza od swojej genialnej poprzedniczki. Mysz Rival 3 została wykonana z bardzo wytrzymałych materiał&oacute;w, a jednocześnie jej konstrukcja jest lekka, komfortowa i ergonomiczna.\r\n\r\nNiezmienną jakość działania zagwarantują mechaniczne przełączniki o wytrzymałości aż 60 milion&oacute;w kliknięć. Sensor PixArt natomiast oferuje precyzję oraz prawdziwe śledzenie ruch&oacute;w użytkownika 1:1.\r\n\r\nCo więcej, dzięki pamięci wewnętrznej możesz zapisać polling rate, mapowanie przycisk&oacute;w oraz do 5 ustawień CPI bezpośrednio na urządzeniu.\r\n\r\nMechaniczne przełączniki\r\nMysz SteelSeries Rival 3 została wyposażona w mechaniczne przełączniki o wytrzymałości aż 60 milion&oacute;w kliknięć. W przełącznikach zastosowano nie tylko system split trigger, ale r&oacute;wnież mechanizm zapewniający wytrzymałość i niezmienna jakość działania, identycz', '149.00', 1),
(32, 'HP OfficeJet 8012e', 'HP Instant Ink\r\nTa drukarka jest kompatybilna z usługą HP Instant Ink. Kup urządzenie i oszczędzaj na eksploatacji nawet 70%. HP Instant Ink to usługa subskrypcji tuszu, kt&oacute;ra sprawia, że drukowanie jest:\r\n\r\n- tańsze nawet o 70%\r\n- ekologiczne\r\n- niezawodne\r\n\r\nJak to działa?\r\nZarejestruj swoją drukarkę i wybierz subskrypcję HP Instant Ink &ndash; TUTAJ\r\nSprawdź ile stron drukujesz i wybierz odpowiedni plan subskrypcji &ndash; już od 4,99 zł miesięcznie\r\nTwoja drukarka sama zam&oacute;wi materiały eksploatacyjne, abyś otrzymał je zanim odczujesz brak\r\nW subskrypcji płacisz tyle samo za strony kolorowe, co za czarno-białe i oszczędzasz nawet 70% koszt&oacute;w\r\nMożesz w pełni kontrolować i zmieniać plan subskrypcji dostosowując go do swoich aktualnych potrzeb\r\n\r\nUrządzenie wielofunkcyjne idealne do domu i małego biura HP Envy 8012e z HP+\r\nHP Envy 8012e z usługą HP+ to idealne rozwiązanie, gdy musisz szybko wydrukować bądź skopiować dokumenty przed wyjściem albo prowadzisz małą fir', '699.00', 1),
(33, 'A4Tech KV-300H Slim szaro-czarna USB', 'Klawiatura do domu i biura A4Tech KV-300H Slim\r\nSkonstruowana w klasycznym stylu, prosta i wygodna. Popraw ergonomię swojej pracy, wybierając klawiaturę A4Tech KV-300H Slim. Przemyślana konstrukcja pozwala na wygodną pracę, nie męczy nadgarstk&oacute;w i dłoni. Cały dzień pisania w biurze czy wieczorne rozmowy ze znajomymi na czacie - teraz to wszystko wykonasz lekko i wygodnie.\r\n\r\nA4Tech KV-300H Slim wyr&oacute;żnia się swoim niskoprofilowym designem w odcieniach szarości i grafitu, kt&oacute;ry z pewnością dopasuje się do każdego nowoczesnego biura. Niski profil klawiszy daje odczucie pisania jak na laptopie, zapewniając komfort podczas użytkowania. Wyposażona w antypoślizgowe stopki uniemożliwia uciążliwemu przesuwaniu podczas pracy czy rozrywki. Dodatkowo A4Tech KV-300H Slim została wyposażona w dwa porty USB 2.0 do kt&oacute;rych podłączysz kolejne urządzenia peryferyjne.', '129.99', 1),
(34, 'Intel Core i7-10700K', 'Procesor Intel Core i7-10700K\r\nPoznaj moc do dziesiątej potęgi. Nowy, odblokowany procesor Intel&reg; Core&trade; i7-10700K z rodziny Comet Lake zapewnia znacznie wyższą wydajność, kt&oacute;ra przekłada się na wzrost produktywności i fantastyczną rozrywkę. Intel Core i7 10-generacji oferuje m.in. częstotliwość dochodzącą do 5.1 GHz w trybie turbo, 8 rdzeni, 16 wątk&oacute;w, a także inteligentną optymalizację systemu. Wbudowane inteligentne funkcje wydajności uczą się i przystosowują do nawyk&oacute;w użytkownika oraz dynamicznie kierują moc, tam gdzie jest najbardziej potrzebna. Odkryj nowe ultramożliwości z procesorem Intel&reg; Core&trade; i7-10700K.', '1649.00', 1),
(35, 'RAM DDR4 HyperX Fury Red 16GB (2x8GB) 2666MHz CL16', 'Odkryj pamięć RAM DDR4 HyperX FURY 2x8GB w 360 stopniach\r\nZmodernizuj sw&oacute;j system dzięki ekonomicznej i wysokowydajnej pamięci RAM DDR4 HyperX FURY, oferującej taktowanie 2666 MHz oraz op&oacute;źnienia na poziomie CL16. Każdy moduł pamięci FURY DDR4 przechodzi testy przy pełnej szybkości i jest objęty wieczystą gwarancją. To bezproblemowa i przystępna cenowo modernizacja Twojego systemu.\r\n\r\nSprawdź, jak HyperX FURY wygląda w rzeczywistości. Chwyć zdjęcie poniżej i przeciągnij je w lewo lub prawo aby obr&oacute;cić produkt lub skorzystaj z przycisk&oacute;w nawigacyjnych.', '339.00', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logged_in_users`
--

CREATE TABLE `logged_in_users` (
  `sessionId` varchar(100) NOT NULL,
  `userId` int(11) NOT NULL,
  `lastUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `logged_in_users`
--

INSERT INTO `logged_in_users` (`sessionId`, `userId`, `lastUpdate`) VALUES
('gq4tecs1ahllbei17h5fuhe21l', 4, '2021-10-29 15:10:19');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orderitems`
--

CREATE TABLE `orderitems` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `orderitems`
--

INSERT INTO `orderitems` (`id`, `orderId`, `itemId`, `quantity`) VALUES
(2, 5, 34, 1),
(3, 5, 35, 1),
(4, 6, 1, 1),
(5, 6, 12, 1),
(6, 6, 33, 4),
(7, 7, 34, 1),
(8, 7, 35, 2),
(10, 9, 12, 1),
(11, 10, 12, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `totalPrice` decimal(6,2) NOT NULL,
  `addressId` int(11) NOT NULL,
  `paymetnAddressId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `orders`
--

INSERT INTO `orders` (`id`, `userId`, `date`, `totalPrice`, `addressId`, `paymetnAddressId`) VALUES
(5, 6, '2021-01-18 13:46:47', '1988.00', 6, NULL),
(6, 6, '2021-01-18 13:47:33', '84.74', 7, NULL),
(7, 4, '2021-01-18 14:36:50', '2327.00', 8, NULL),
(9, 6, '2021-10-29 14:05:49', '10.00', 7, NULL),
(10, 4, '2021-10-29 15:13:39', '447.00', 8, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `userName`, `email`, `passwd`, `status`, `date`) VALUES
(4, 'admin', 'aaa@aaa.pl', '951fa2c0eedf86ae75e3b66da7bc109ba77d75b2c9f241789be572ae4d92e09d', 2, '2021-01-17 00:00:00'),
(6, 'user', 'user@sklep.pl', '951fa2c0eedf86ae75e3b66da7bc109ba77d75b2c9f241789be572ae4d92e09d', 1, '2021-01-18 00:00:00');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `logged_in_users`
--
ALTER TABLE `logged_in_users`
  ADD PRIMARY KEY (`sessionId`),
  ADD KEY `UserIdFK` (`userId`);

--
-- Indeksy dla tabeli `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ItemIdOI_FK` (`itemId`),
  ADD KEY `orderIdOI_FK` (`orderId`);

--
-- Indeksy dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserOrderIdFK` (`userId`),
  ADD KEY `AddressIdFK` (`addressId`),
  ADD KEY `PaymentAddressFK` (`paymetnAddressId`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userName` (`userName`,`email`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT dla tabeli `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `logged_in_users`
--
ALTER TABLE `logged_in_users`
  ADD CONSTRAINT `UserIdFK` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `ItemIdOI_FK` FOREIGN KEY (`itemId`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `orderIdOI_FK` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`);

--
-- Ograniczenia dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `AddressIdFK` FOREIGN KEY (`addressId`) REFERENCES `addresses` (`id`),
  ADD CONSTRAINT `PaymentAddressFK` FOREIGN KEY (`paymetnAddressId`) REFERENCES `addresses` (`id`),
  ADD CONSTRAINT `UserOrderIdFK` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
