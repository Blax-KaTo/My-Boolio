-- Create the users table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    phone VARCHAR(10) NOT NULL,
    user_role ENUM('admin', 'manager', 'delivery', 'cook', 'customer') DEFAULT 'customer',
    password VARCHAR(255) NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -- Create the products table
-- CREATE TABLE products (
--   id INT PRIMARY KEY AUTO_INCREMENT,
--   name VARCHAR(255) NOT NULL,
--   description TEXT,
--   price DECIMAL(10, 2) NOT NULL,
--   active BOOLEAN DEFAULT 1
-- );

-- -- Create the ingredients table
-- CREATE TABLE ingredients (
--   id INT PRIMARY KEY AUTO_INCREMENT,
--   name VARCHAR(255) NOT NULL,
--   active BOOLEAN DEFAULT 1
-- );

-- -- Create the product_ingredients table
-- CREATE TABLE product_ingredients (
--   product_id INT,
--   ingredient_id INT,
--   PRIMARY KEY (product_id, ingredient_id),
--   FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
--   FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE
-- );

-- Create the products table
CREATE TABLE products (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10, 2) NOT NULL,
  image VARCHAR(255),
  active BOOLEAN DEFAULT 1
);


-- Create the ingredients table
CREATE TABLE ingredients (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  active BOOLEAN DEFAULT 1
);

-- Create the product_ingredients table
CREATE TABLE product_ingredients (
  product_id INT,
  ingredient_id INT,
  PRIMARY KEY (product_id, ingredient_id),
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE
);

-- Create the orders table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    op_id INT NOT NULL,
    quantity INT NOT NULL,
    location_id INT NOT NULL,
    description TEXT,
    contact VARCHAR(255),
    delivery_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    order_status ENUM('pending', 'order_started', 'delivery', 'completed') DEFAULT 'pending',
    FOREIGN KEY (op_id) REFERENCES ordered_products(id),
    FOREIGN KEY (location_id) REFERENCES locations(id),
    FOREIGN KEY (delivery_id) REFERENCES users(id)
);


-- Create the ordered_products table
CREATE TABLE ordered_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);