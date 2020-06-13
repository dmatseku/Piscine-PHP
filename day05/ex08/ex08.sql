SELECT last_name, first_name, DATE_FORMAT(birthdate, '%Y-%m-%d') FROM user_card
    WHERE EXTRACT(YEAR FROM birthdate) = 1989
    ORDER BY last_name ASC;