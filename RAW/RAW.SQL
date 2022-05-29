
CREATE TABLE member_anyversary(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    anyversary_date date,
	anyversary_type INT,
    member_id INT 
);




DELIMITER $$
CREATE EVENT three_months_anyversary
	ON SCHEDULE EVERY 1 DAY STARTS '2022-03-14 07:00:00' 
	DO 
	BEGIN
		INSERT INTO super_hostel.member_anyversary (anyversary_date, anyversary_type, member_id) 
        SELECT CURDATE(), 3, id
		FROM member_directory 
		where (DATEDIFF(date_format(CURDATE(), "%Y-%m-%d"), date_format(STR_TO_DATE(check_in_date, "%d/%m/%Y"), "%Y-%m-%d"))) = 90 
		and status='1';  
	END $$
DELIMITER ;

DELIMITER $$
CREATE EVENT six_months_anyversary
	ON SCHEDULE EVERY 1 DAY STARTS '2022-03-14 07:00:00' 
	DO 
	BEGIN
		INSERT INTO super_hostel.member_anyversary (anyversary_date, anyversary_type, member_id) 
        SELECT CURDATE(), 6, id
		FROM member_directory 
		where (DATEDIFF(date_format(CURDATE(), "%Y-%m-%d"), date_format(STR_TO_DATE(check_in_date, "%d/%m/%Y"), "%Y-%m-%d"))) = 180 
		and status='1';  
	END $$
DELIMITER ;


DELIMITER $$
CREATE EVENT twelve_months_anyversary
	ON SCHEDULE EVERY 1 DAY STARTS '2022-03-14 07:00:00' 
	DO 
	BEGIN
		INSERT INTO super_hostel.member_anyversary (anyversary_date, anyversary_type, member_id) 
        SELECT CURDATE(), 12, id
		FROM member_directory 
		where (DATEDIFF(date_format(CURDATE(), "%Y-%m-%d"), date_format(STR_TO_DATE(check_in_date, "%d/%m/%Y"), "%Y-%m-%d"))) = 365 
		and status='1';  
	END $$
DELIMITER ;


ALTER TABLE employee_recruitment_request ADD salary varchar(11);
ALTER TABLE employee_recruitment_request ADD job_title varchar(255);


CREATE TABLE document_managment (
	id int(11) primary key auto_increment not null,
    document_name varchar(255),
    expiration_date date,
	renew_date date,
    file_url varchar(255),
    note text
);



CREATE TABLE document_managment_log (
	id int(11) PRIMARY KEY AUTO_INCREMENT NOT null,
	document_id int(11),
    document_name varchar(255),
    renew_date date,
    expiration_date date,
    file_url varchar(255),
    note text 
);

//did not uploaded yet.

CREATE TABLE parking_logs (
	id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	card_holders_id varchar(255) NOT NULL,
    vehicle_in datetime DEFAULT NULL,
	vehicle_out datetime DEFAULT NULL,
	holder_type varchar(255)
);

