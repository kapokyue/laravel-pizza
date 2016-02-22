CREATE TABLE cart (
  user_id    INT(11) NOT NULL,
  product_id INT(11) NOT NULL,
  PRIMARY KEY (user_id, product_id)
);

CREATE TABLE category (
  id   INT(10) PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL
);

INSERT INTO category (id, name) VALUES
  (1, 'Pizzas'),
  (2, 'Pasta'),
  (3, 'Drinks'),
  (4, 'Snacks'),
  (5, 'Combo Set');

CREATE TABLE customer_order (
  id       INT(10) PRIMARY KEY   AUTO_INCREMENT,
  charge   INT(10)      NOT NULL,
  status   VARCHAR(255) NOT NULL,
  order_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  user_id  INT(10)      NOT NULL,
  address  VARCHAR(255) NOT NULL,
  note     VARCHAR(255)
);

CREATE TABLE order_item (
  product_id INT(10) NOT NULL,
  order_id   INT(10) NOT NULL,
  qty        INT(10) NOT NULL,
  PRIMARY KEY (product_id, order_id)
);

CREATE TABLE product (
  id          INT(10) PRIMARY KEY AUTO_INCREMENT,
  name        VARCHAR(255) NOT NULL,
  price       INT(10)      NOT NULL,
  category_id INT(10)      NOT NULL,
  description VARCHAR(255) NOT NULL,
  img         VARCHAR(255) NOT NULL
);

INSERT INTO product (id, name, price, category_id, description, img) VALUES
  (1, '9'' Round Meat Lover''s', 50, 1, 'Latest 9'' round pizza', '/img/pizza.jpg'),
  (2, '12'' Round Meat Lover''s', 80, 1, 'Latest 12'' round pizza', '/img/pizza.jpg'),
  (3, '9'' Round Meat Lover''s', 50, 1, 'Latest 9'' round pizza', '/img/pizza.jpg'),
  (4, '12'' Round Meat Lover''s', 80, 1, 'Latest 12'' round pizza', '/img/pizza.jpg'),
  (5, '8''x9'' Rect Meat Lover''s', 120, 1, 'Latest 8''x9''rectangular pizza', '/img/pizza3.jpg'),
  (6, '8''x9'' Rect Meat Lover''s', 70, 1, 'Latest 8''x9''rectangular pizza', '/img/pizza3.jpg'),
  (7, '9'' Round Salmon Island', 45, 1, 'Latest 9'' round pizza', '/img/pizza2.jpg'),
  (8, 'Salmon with Herb', 30, 2, 'Super Value', '/img/pasta.jpg'),
  (9, 'Meat Sauce', 40, 2, 'Super Value', '/img/pasta2.jpg'),
  (10, 'Coca Cola', 10, 3, 'Good', '/img/drink.jpg'),
  (11, 'Sprite', 10, 3, 'Good', '/img/drink2.jpg'),
  (12, 'Fried Chicken', 25, 4, 'Very Good', '/img/snack4.jpg'),
  (13, 'Potato Wedge', 25, 4, 'Very Good', '/img/snack.jpg'),
  (14, 'Serradura', 15, 4, 'Very Good', '/img/snack2.jpg'),
  (15, 'Combo Set A', 120, 5, 'Super Valuable', '/img/ComboSet.jpg'),
  (25, 'Combo Set C', 120, 5, 'Super Valuable', '/img/ComboSet.jpg'),
  (26, 'Combo Set B', 180, 5, 'Super Good', '/img/ComboSet.jpg'),
  (27, 'Combo Set D', 180, 5, 'Super Good', '/img/ComboSet.jpg');

CREATE TABLE system_user (
  id             INT(10) PRIMARY KEY AUTO_INCREMENT,
  name           VARCHAR(255) NOT NULL,
  phone          VARCHAR(15)  NOT NULL,
  account        VARCHAR(255) NOT NULL UNIQUE,
  password       VARCHAR(255) NOT NULL,
  type           VARCHAR(255) NOT NULL,
  remember_token VARCHAR(255)
);

-- No hash for password
INSERT INTO system_user (id, name, phone, account, password, type) VALUES
  (1, 'C', '12345678', 'c', '123456', 'C'),
  (2, 'M', '12345678', 'm', '123456', 'M');

ALTER TABLE cart
ADD CONSTRAINT product_pk FOREIGN KEY (product_id) REFERENCES product (id),
ADD CONSTRAINT user_pk FOREIGN KEY (user_id) REFERENCES system_user (id);

ALTER TABLE customer_order
ADD CONSTRAINT user_fk FOREIGN KEY (user_id) REFERENCES system_user (id);

ALTER TABLE order_item
ADD CONSTRAINT order_fk FOREIGN KEY (order_id) REFERENCES customer_order (id),
ADD CONSTRAINT product_fk FOREIGN KEY (product_id) REFERENCES product (id);

ALTER TABLE product
ADD CONSTRAINT category_fk FOREIGN KEY (category_id) REFERENCES category (id);
