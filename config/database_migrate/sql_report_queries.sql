--/ APPOINTMENTS: Get all Seen patients from Appointments for the current day of the current month/--
SELECT * FROM `appointments` WHERE DAY(app_date) = DAY(NOW()) AND status = 2;

--/ APPOINTMENTS: Get all Seen patients from Appointments for the current  month/--
SELECT * FROM `appointments` WHERE MONTH(app_date) = MONTH(NOW()) AND status = 2;

--/ INVOICES: get total amount of all UNPAID invoices for the current Year&Month /--
SELECT SUM(amount) AS total_unpaid FROM `invoices` WHERE DATE_FORMAT(created, 'm%, Y%') = DATE_FORMAT(NOW(), 'm%, Y%') AND status = 0

--/ INVOICES: get total amount of all PAID invoices for the current Year&Month /--
SELECT SUM(amount) AS total_paid FROM `invoices` WHERE DATE_FORMAT(created, 'm%, Y%') = DATE_FORMAT(NOW(), 'm%, Y%') AND status = 1

--/ INVOICES: count total number of all UNPAID invoices for the current Year&Month /--
SELECT COUNT(idnumber) AS totalUnpaidCount FROM `invoices` WHERE DATE_FORMAT(created, 'm%, Y%') = DATE_FORMAT(NOW(), 'm%, Y%') AND status = 0

--/ INVOICES: count total number of all PAID invoices for the current Year&Month /--
SELECT COUNT(idnumber) AS totalPaidCount FROM `invoices` WHERE DATE_FORMAT(created, 'm%, Y%') = DATE_FORMAT(NOW(), 'm%, Y%') AND status = 1

--/ APPOINTMENTS: Get total number of registered patients from Appointments for the current month of current year/--
SELECT COUNT(idnumber) FROM `patients` WHERE DATE_FORMAT(created, 'm%, %Y') = DATE_FORMAT(NOW(), 'm%, Y%');

--/ BIRTHDAYS: get all patients birth date where dateOfBirth is this current day in current month /--
SELECT * FROM `patients` WHERE DAY(dob) = DAY(NOW());

--/ BIRTHDAYS: get all patients birth date where BirthMonth is Next Month /--
SELECT * FROM `patients` WHERE MONTH(dob) = MONTH((NOW() + INTERVAL 1 MONTH));

--/ BIRTHDAYS: get all patients birth date where dateOfBirth is in 7days of current Month of current Year/--
SELECT * FROM `patients` WHERE DATE_FORMAT(dob, 'd%-m%') = DATE_FORMAT(NOW(), 'd%-m%') + INTERVAL 7 days LIMIT 0,5;

--/ STOCK_LEVELS: get all products with units level low that needs to be refordered /--
SELECT `product_name`, `units_level` FROM `products` WHERE units_level <= 20;

--/ PRODUCT_SALES: get total Top-10 units sold previous Year/--
SELECT *, MONTH(created) AS prevMonth, SUM(quantity) AS units 
FROM `orders`  WHERE DATE_FORMAT(created, 'Y%-%m') = DATE_FORMAT(NOW(), 'Y%-%m') - INTERVAL 1 MONTH) LIMIT 0, 10;

--/ PRODUCT_SALES: get total Top-10 units sold previous Year/--
SELECT *, YEAR(created) AS prevYear, SUM(quantity) AS units FROM `orders` WHERE YEAR(created) = YEAR(NOW() - INTERVAL 1 MONTH) LIMIT 0, 10;