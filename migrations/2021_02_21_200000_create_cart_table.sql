CREATE TABLE cart_items (
  id int(11) NOT NULL AUTO_INCREMENT,
  product_id int(11) NOT NULL,
  quantity double NOT NULL,
  user_id int(11) NOT NULL,
  created datetime NOT NULL,
  modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id) REFERENCES customers(id)
)