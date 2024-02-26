CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE amadeus_data (
    id INT PRIMARY KEY AUTO_INCREMENT,
    city_code VARCHAR(3) NOT NULL,
    city_name VARCHAR(100) NOT NULL,
    flight_shortname VARCHAR(20) NOT NULL
);

CREATE TABLE sessions (
    user_id INT,
    session_token VARCHAR(255) PRIMARY KEY,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE flights (
    flight_id INT PRIMARY KEY AUTO_INCREMENT,
    airline VARCHAR(100) NOT NULL,
    flight_number VARCHAR(20) NOT NULL,
    origin_airport_code VARCHAR(3) NOT NULL,
    destination_airport_code VARCHAR(3) NOT NULL,
    departure_time DATETIME NOT NULL,
    arrival_time DATETIME NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    available_seats INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bookings (
    booking_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    flight_id INT,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (flight_id) REFERENCES flights(flight_id)
);


-- Create the 'orderdetails' database
CREATE DATABASE IF NOT EXISTS orderdetails;

-- Switch to the 'orderdetails' database
USE orderdetails;

-- Create the 'orders' table to store order details
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(255) NOT NULL,
    queuing_office_id VARCHAR(255) NOT NULL,
    booking_date DATETIME NOT NULL,
    remarks TEXT,
    UNIQUE KEY (order_id)
);

-- Create the 'travelers' table to store traveler details
CREATE TABLE IF NOT EXISTS travelers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    traveler_id VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    UNIQUE KEY (order_id, traveler_id)
);

-- Create the 'flights' table to store flight details
CREATE TABLE IF NOT EXISTS flights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    flight_id VARCHAR(255) NOT NULL,
    source VARCHAR(255) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    currency VARCHAR(3) NOT NULL,
    departure_airport VARCHAR(255) NOT NULL,
    arrival_airport VARCHAR(255) NOT NULL,
    departure_time DATETIME NOT NULL,
    arrival_time DATETIME NOT NULL,
    airline_code VARCHAR(10) NOT NULL,
    flight_number VARCHAR(255) NOT NULL,
    cabin_class VARCHAR(20) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    UNIQUE KEY (order_id, flight_id)
);

-- Create the 'locations' table to store location details
CREATE TABLE IF NOT EXISTS locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    location_code VARCHAR(255) NOT NULL,
    city_code VARCHAR(255) NOT NULL,
    country_code VARCHAR(2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    UNIQUE KEY (order_id, location_code)
);

// show order featch join
SELECT
    orders.order_id,
    orders.booking_date,
    travelers.date_of_birth,
    travelers.gender,
    travelers.first_name,
    travelers.last_name,
    travelers.email,
    departure_airport.city AS source_city,
    departure_airport.country AS source_country,
    arrival_airport.city AS destination_city,
    arrival_airport.country AS destination_country,
    flights.departure_time,
    flights.arrival_time,
    flights.airline_code,
    flights.flight_number,
    flights.cabin_class
FROM
    orders
JOIN travelers ON orders.id = travelers.order_id
JOIN flights ON orders.id = flights.order_id
JOIN locations ON orders.id = locations.order_id
JOIN airports AS departure_airport ON flights.departure_airport = departure_airport.iata_code
JOIN airports AS arrival_airport ON flights.arrival_airport = arrival_airport.iata_code;
