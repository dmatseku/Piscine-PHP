USE admin_rush;

DROP TABLE IF EXISTS Dependencies;

CREATE OR REPLACE TABLE Products (
    product_id INT NOT NULL AUTO_INCREMENT,
    product_name VARCHAR(50) NOT NULL,
    product_price INT NOT NULL,
    product_image_link VARCHAR(100) NOT NULL,
    PRIMARY KEY (product_id));

CREATE OR REPLACE TABLE Categories (
    category_id INT NOT NULL AUTO_INCREMENT,
    category_name VARCHAR(50) NOT NULL,
    PRIMARY KEY (category_id));
  
CREATE OR REPLACE TABLE Dependencies (
    category_id INT NOT NULL,
    product_id INT NOT NULL,
    INDEX fk_product_idx (product_id ASC),
    INDEX fk_category_idx (category_id ASC),
    PRIMARY KEY (category_id, product_id),
    CONSTRAINT fk_product
        FOREIGN KEY (product_id)
            REFERENCES Products (product_id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION,
    CONSTRAINT fk_category
        FOREIGN KEY (category_id)
            REFERENCES Categories (category_id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION);

DROP TABLE IF EXISTS Auth_log;

CREATE OR REPLACE TABLE Users (
    user_id INT NOT NULL AUTO_INCREMENT,
    user_login VARCHAR(30) NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    admin_permissions BOOL DEFAULT false,
    PRIMARY KEY (user_id),
    UNIQUE INDEX user_login_UNIQUE (user_login ASC));


CREATE OR REPLACE TABLE Auth_log (
    user_hash VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    user_agent VARCHAR(255) NOT NULL,
    INDEX fk_user_id_idx (user_id ASC),
    CONSTRAINT fk_user_id
        FOREIGN KEY (user_id)
            REFERENCES Users (user_id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION);

DELIMITER $$

CREATE OR REPLACE PROCEDURE insert_new_product(IN p_name VARCHAR(50), IN p_price INT, IN p_image_link VARCHAR(50))
BEGIN
    DECLARE product_exists INT;

    SELECT count(*) INTO product_exists FROM Products
    WHERE product_name = p_name
    LIMIT 1;

    IF product_exists = 0 THEN
        INSERT INTO Products(product_name, product_price, product_image_link)
        VALUES (p_name, p_price, p_image_link);
        SELECT 1;
    END IF;
END$$

CREATE OR REPLACE PROCEDURE update_product(IN p_id INT, IN p_name VARCHAR(50), IN p_price INT, IN p_link VARCHAR(100))
BEGIN
    UPDATE Products
    SET product_name = p_name, product_price = p_price, product_image_link = p_link
    WHERE product_id = p_id;
end $$

CREATE OR REPLACE PROCEDURE delete_product(IN id INT)
BEGIN
    DELETE FROM Products
    WHERE product_id = id
    LIMIT 1;
END$$

CREATE OR REPLACE PROCEDURE product_is_exists(IN p_id INT)
BEGIN
    SELECT product_id FROM Products
    WHERE product_id = p_id
    LIMIT 1;
END$$

CREATE OR REPLACE PROCEDURE get_product_id_by_name(IN p_name VARCHAR(50))
BEGIN
    SELECT product_id FROM Products
    WHERE product_name = p_name
    LIMIT 1;
END$$

CREATE OR REPLACE PROCEDURE get_product(IN id INT)
BEGIN
	SELECT product_name, product_price, product_image_link FROM Products
    WHERE product_id = id
	LIMIT 1;
END$$


CREATE OR REPLACE PROCEDURE insert_new_category(IN c_name VARCHAR(50))
BEGIN
    DECLARE category_exists INT;

    SELECT count(*) INTO category_exists FROM Categories
    WHERE category_name = c_name
    LIMIT 1;

    IF category_exists = 0 THEN
        INSERT INTO Categories(category_name)
        VALUES (c_name);
        SELECT 1;
    END IF;
END$$

CREATE OR REPLACE PROCEDURE update_category_name(IN old_name VARCHAR(50), IN new_name VARCHAR(50))
BEGIN
    DECLARE category_exists INT;


    SELECT count(*) INTO category_exists FROM Categories
    WHERE category_name = old_name
    LIMIT 1;

    IF category_exists > 0 THEN
        UPDATE Categories
        SET category_name = new_name
        WHERE category_name = old_name
        LIMIT 1;
        SELECT 1;
    END IF;
END$$

CREATE OR REPLACE PROCEDURE delete_category(IN id INT)
BEGIN
    DELETE FROM Categories
    WHERE category_id = id
    LIMIT 1;
END$$

CREATE OR REPLACE PROCEDURE get_categories_list()
BEGIN
	SELECT category_name AS name FROM Categories
	WHERE category_id IN (SELECT category_id FROM Dependencies)
	ORDER BY category_name;
END$$

CREATE OR REPLACE PROCEDURE get_full_categories_list()
BEGIN
    SELECT category_name AS name, category_id AS id FROM Categories
    ORDER BY category_name;
END$$

CREATE OR REPLACE PROCEDURE get_dependencies_for_product(IN p_id INT)
BEGIN
    SELECT category_id AS c_id FROM Dependencies
    WHERE product_id = p_id;
END$$

CREATE OR REPLACE PROCEDURE add_dependency(IN p_id INT, IN c_id INT)
BEGIN
    INSERT INTO Dependencies (category_id, product_id)
    VALUES (c_id, p_id);
END$$

CREATE OR REPLACE PROCEDURE delete_dependency(IN p_id INT, IN c_id INT)
BEGIN
    DELETE FROM Dependencies
    WHERE product_id = p_id AND category_id = c_id;
END$$

CREATE OR REPLACE PROCEDURE get_limited_products(IN max_count INT)
BEGIN
    SELECT Categories.category_name, numbered_table.product_id, Products.product_name, Products.product_price, Products.product_image_link
    FROM (
             SELECT category_id,
                    product_id,
                    row_number() OVER (PARTITION BY category_id) AS nb
             FROM Dependencies
             ORDER BY category_id, product_id DESC
         ) numbered_table
             INNER JOIN Categories ON numbered_table.category_id = Categories.category_id
             INNER JOIN Products ON numbered_table.product_id = Products.product_id
    WHERE numbered_table.nb <= max_count
    GROUP BY Categories.category_id, Products.product_id
    LIMIT 30;
END$$

CREATE OR REPLACE PROCEDURE get_desired_products(IN category VARCHAR(50), IN product VARCHAR(50))
BEGIN
    SELECT Categories.category_name, Dependencies.product_id, Products.product_name, Products.product_price, Products.product_image_link
    FROM Dependencies
    INNER JOIN Categories ON Dependencies.category_id = Categories.category_id
    INNER JOIN Products ON Dependencies.product_id = Products.product_id
    WHERE Categories.category_name LIKE category AND Products.product_name LIKE product
    ORDER BY Categories.category_id, Products.product_id;
END$$

CREATE OR REPLACE PROCEDURE get_orphan_products(IN mask VARCHAR(50))
BEGIN
    SELECT * FROM Products
    WHERE product_id LIKE mask
    AND product_id NOT IN (SELECT product_id FROM Dependencies)
    ORDER BY product_id;
END$$

CREATE OR REPLACE PROCEDURE clear_old_logs(IN u_id INT)
BEGIN
    DELETE FROM Auth_log
    WHERE user_id = u_id;
END$$

CREATE OR REPLACE PROCEDURE insert_log(IN u_hash VARCHAR(255), IN u_id INT, IN u_agent VARCHAR(255))
BEGIN
    INSERT INTO Auth_log (user_hash, user_id, user_agent)
    VALUES (u_hash, u_id, u_agent);
END$$

CREATE OR REPLACE PROCEDURE find_log(IN u_hash VARCHAR(255), IN u_id INT, IN u_agent VARCHAR(255))
BEGIN
    SELECT Users.user_login FROM Auth_log
    INNER JOIN Users on Auth_log.user_id = Users.user_id
    WHERE user_hash = u_hash AND Auth_log.user_id = u_id AND user_agent = u_agent
    LIMIT 1;
END$$

CREATE OR REPLACE PROCEDURE update_password(IN login VARCHAR(30), IN passwd VARCHAR(255))
BEGIN
    UPDATE Users
    SET user_password = passwd
    WHERE user_login = login;
END$$

CREATE OR REPLACE PROCEDURE get_password(IN needed_login VARCHAR(30))
BEGIN
    SELECT user_password FROM Users
    WHERE user_login = needed_login
    LIMIT 1;
END$$

CREATE OR REPLACE PROCEDURE get_id_by_login(IN u_login VARCHAR(30))
BEGIN
    SELECT user_id FROM Users
    WHERE user_login = u_login
    LIMIT 1;
END$$

CREATE OR REPLACE PROCEDURE register_user(IN u_login VARCHAR(30), IN u_password VARCHAR(255))
BEGIN
    DECLARE user_exists INT;

    SELECT count(*) INTO user_exists FROM Users
    WHERE user_login = u_login
    LIMIT 1;

    IF user_exists = 0 THEN
        INSERT INTO Users(user_login, user_password)
        VALUES (u_login, u_password);
        SELECT 1;
    END IF;
END$$

CREATE OR REPLACE PROCEDURE remove_user(IN u_login VARCHAR(30))
BEGIN
    DECLARE user_exists INT;

    SELECT count(*) INTO user_exists FROM Users
    WHERE user_login = u_login
    LIMIT 1;

    IF user_exists > 0 THEN
        DELETE FROM Users
        WHERE user_login = u_login
        LIMIT 1;
        SELECT 1;
    END IF;
END$$

CREATE OR REPLACE PROCEDURE give_privileges(IN u_id INT)
BEGIN
    UPDATE Users
    SET admin_permissions = true
    WHERE user_id = u_id;
END$$

CREATE OR REPLACE PROCEDURE take_privileges_away(IN u_id INT)
BEGIN
    UPDATE Users
    SET admin_permissions = false
    WHERE user_id = u_id;
END$$

CREATE OR REPLACE PROCEDURE get_privileges_user(IN u_login VARCHAR(30))
BEGIN
    SELECT admin_permissions FROM Users
    WHERE user_login = u_login
    LIMIT 1;
END$$

DELIMITER ;
