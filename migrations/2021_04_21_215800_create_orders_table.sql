CREATE TABLE IF NOT EXISTS orders (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  customer_id INT(11) NOT NULL,
  contact_details TEXT NOT NULL,
  shipping_address TEXT NOT NULL,
  products TEXT NOT NULL,
  card_info TEXT NOT NULL,
  amount varchar(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES customers(id)
);