CREATE DATABASE UniqueEmployeesData;
USE UniqueEmployeesData;

CREATE TABLE Employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    atesia VARCHAR(50) NOT NULL,
    amesia VARCHAR(50) NOT NULL,
    data_e_lindjes DATE NOT NULL,
    numri_i_pashaportes VARCHAR(50) NOT NULL,
    vlefshmeria_e_pashaportes DATE NOT NULL,
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    start_date DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    work_date DATE NOT NULL,
    visa_start DATE NOT NULL,
    visa_end DATE NOT NULL,
    work_place VARCHAR(100) NOT NULL
);
