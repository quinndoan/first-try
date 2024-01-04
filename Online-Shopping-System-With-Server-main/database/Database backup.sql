SET NOCOUNT ON; -- This is equivalent to "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';" in MySQL
SET ANSI_NULLS ON;
SET QUOTED_IDENTIFIER ON;
GO

-- Start a transaction
BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL READ COMMITTED;

-- Set the time zone (SQL Server does not use this syntax, as it handles time zones differently)
-- You may need to handle time zone conversions in your application logic

-- Database creation is not included here, as it's usually handled separately in SQL Server

-- Stored procedure creation 
CREATE PROCEDURE getcat
    @cid INT
AS
BEGIN
    SELECT * FROM categories WHERE cat_id = @cid;
END;

-- Table structure for admin_info
CREATE TABLE admin_info (
    admin_id INT NOT NULL,
    admin_name VARCHAR(100) NOT NULL,
    admin_email VARCHAR(300) NOT NULL,
    admin_password VARCHAR(300) NOT NULL,
    PRIMARY KEY (admin_id)
);

-- Insert data into admin_info
INSERT INTO admin_info (admin_id, admin_name, admin_email, admin_password)
VALUES (1, 'admin', 'admin@apricotstore.com', '25f9e794323b453885f5181f1b624d0b');

-- Table structure for brands
CREATE TABLE brands (
    brand_id INT NOT NULL,
    brand_title NVARCHAR(MAX) NOT NULL,
    PRIMARY KEY (brand_id)
);

-- Insert data into brands
INSERT INTO brands (brand_id, brand_title)
VALUES
(1, 'HP'),
(2, 'Samsung'),
(3, 'Apple'),
(4, 'motorolla'),
(5, 'LG'),
(6, 'Cloth Brand');

-- Table structure for cart
CREATE TABLE cart (
    id INT NOT NULL,
    p_id INT NOT NULL,
    ip_add VARCHAR(250) NOT NULL,
    user_id INT,
    qty INT NOT NULL,
    PRIMARY KEY (id)
);

-- Insert data into cart
-- Note: You'll need to replace the VALUES with actual data
INSERT INTO cart (id, p_id, ip_add, user_id, qty)
VALUES (1, 123, '192.168.1.1', NULL, 5);

-- Insert data into cart table
INSERT INTO cart (id, p_id, ip_add, user_id, qty)
VALUES
(6, 26, '::1', 4, 1),
(9, 10, '::1', 7, 1),
(10, 11, '::1', 7, 1),
(11, 45, '::1', 7, 1),
(44, 5, '::1', 3, 0),
(46, 2, '::1', 3, 0),
(48, 72, '::1', 3, 0),
(49, 60, '::1', 8, 1),
(50, 61, '::1', 8, 1),
(51, 1, '::1', 8, 1),
(52, 5, '::1', 9, 1),
(53, 2, '::1', 14, 1),
(54, 3, '::1', 14, 1),
(55, 5, '::1', 14, 1),
(56, 1, '::1', 9, 1),
(57, 2, '::1', 9, 1),
(71, 61, '127.0.0.1', -1, 1);

-- Table structure for categories
CREATE TABLE categories (
    cat_id INT NOT NULL,
    cat_title NVARCHAR(MAX) NOT NULL,
    PRIMARY KEY (cat_id)
);

-- Insert data into categories
INSERT INTO categories (cat_id, cat_title)
VALUES
(1, 'Electronics'),
(2, 'Ladies Wears'),
(3, 'Mens Wear'),
(4, 'Kids Wear'),
(5, 'Furnitures'),
(6, 'Home Appliances'),
(7, 'Electronics Gadgets');

-- Table structure for email_info
CREATE TABLE email_info (
    email_id INT NOT NULL,
    email NVARCHAR(MAX) NOT NULL,
    PRIMARY KEY (email_id)
);

-- Insert data into email_info
INSERT INTO email_info (email_id, email)
VALUES
(3, 'admin@apricotstore.com'),
(4, 'help.shohan@gmail.com'),
(5, 'info.shohan@yahoo.com');

-- Table structure for logs
CREATE TABLE logs (
    id INT NOT NULL,
    user_id NVARCHAR(50) NOT NULL,
    action NVARCHAR(50) NOT NULL,
    date DATETIME NOT NULL,
    PRIMARY KEY (id)
);

-- Table structure for orders
CREATE TABLE orders (
    order_id INT NOT NULL,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    qty INT NOT NULL,
    trx_id NVARCHAR(255) NOT NULL,
    p_status NVARCHAR(20) NOT NULL,
    PRIMARY KEY (order_id)
);

-- Insert data into orders
INSERT INTO orders (order_id, user_id, product_id, qty, trx_id, p_status)
VALUES
(1, 12, 7, 1, '07M47684BS5725041', 'Completed'),
(2, 14, 2, 1, '07M47684BS5725041', 'Completed');

-- Table structure for orders_info
CREATE TABLE orders_info (
    order_id INT NOT NULL,
    user_id INT NOT NULL,
    f_name NVARCHAR(255) NOT NULL,
    email NVARCHAR(255) NOT NULL,
    address NVARCHAR(255) NOT NULL,
    city NVARCHAR(255) NOT NULL,
    state NVARCHAR(255) NOT NULL,
    zip INT NOT NULL,
    cardname NVARCHAR(255) NOT NULL,
    cardnumber NVARCHAR(20) NOT NULL,
    expdate NVARCHAR(255) NOT NULL,
    prod_count INT DEFAULT NULL,
    total_amt INT DEFAULT NULL,
    cvv INT NOT NULL,
    PRIMARY KEY (order_id)
);

-- Insert data into orders_info
INSERT INTO orders_info (order_id, user_id, f_name, email, address, city, state, zip, cardname, cardnumber, expdate, prod_count, total_amt, cvv)
VALUES
(1, 12, 'Shohan', 'help.shohan@gmail.com', 'Dhaka, Khulna, Barisal', 'Daffodil Smart City', 'Barisal', 560074, 'pokjhgfcxc', '4321 2345 6788 7654', '12/90', 3, 77000, 1234);

-- Table structure for order_products
CREATE TABLE order_products (
    order_pro_id INT NOT NULL,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    qty INT DEFAULT NULL,
    amt INT DEFAULT NULL,
    PRIMARY KEY (order_pro_id)
);

-- Insert data into order_products
INSERT INTO order_products (order_pro_id, order_id, product_id, qty, amt)
VALUES
(73, 1, 1, 1, 5000),
(74, 1, 4, 2, 64000),
(75, 1, 8, 1, 40000);

-- Table structure for products
CREATE TABLE products (
    product_id INT NOT NULL,
    product_cat INT NOT NULL,
    product_brand INT NOT NULL,
    product_title NVARCHAR(255) NOT NULL,
    product_price INT NOT NULL,
    product_desc NVARCHAR(MAX) NOT NULL,
    product_image NVARCHAR(MAX) NOT NULL,
    product_keywords NVARCHAR(MAX) NOT NULL,
    PRIMARY KEY (product_id)
);
-- Table structure for products
CREATE TABLE products (
    product_id INT NOT NULL,
    product_cat INT NOT NULL,
    product_brand INT NOT NULL,
    product_title NVARCHAR(255) NOT NULL,
    product_price INT NOT NULL,
    product_desc NVARCHAR(MAX) NOT NULL,
    product_image NVARCHAR(MAX) NOT NULL,
    product_keywords NVARCHAR(MAX) NOT NULL,
    PRIMARY KEY (product_id)
);

-- Insert data into products
INSERT INTO products (product_id, product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords)
VALUES
(1, 1, 2, 'Samsung galaxy s7 edge', 5000, 'Samsung galaxy s7 edge', 'product07.png', 'samsung mobile electronics'),
(2, 1, 3, 'iPhone 5s', 25000, 'iphone 5s', 'http___pluspng.com_img-png_iphone-hd-png-iphone-apple-png-file-550.png', 'mobile iphone apple'),
(3, 1, 3, 'iPad air 2', 30000, 'ipad apple brand', 'da4371ffa192a115f922b1c0dff88193.png', 'apple ipad tablet'),
(4, 1, 3, 'iPhone 6s', 32000, 'Apple iPhone ', 'http___pluspng.com_img-png_iphone-6s-png-iphone-6s-gold-64gb-1000.png', 'iphone apple mobile'),
(5, 1, 2, 'iPad 2', 10000, 'samsung ipad', 'iPad-air.png', 'ipad tablet samsung'),
(6, 1, 1, 'samsung Laptop r series', 35000, 'samsung Black combination Laptop', 'laptop_PNG5939.png', 'samsung laptop '),
(7, 1, 1, 'Laptop Pavillion', 50000, 'Laptop Hp Pavillion', 'laptop_PNG5930.png', 'Laptop Hp Pavillion'),
(8, 1, 4, 'Sony', 40000, 'Sony Mobile', '530201353846AM_635_sony_xperia_z.png', 'sony mobile'),
(9, 1, 3, 'iPhone New', 12000, 'iphone', 'iphone-hd-png-iphone-apple-png-file-550.png', 'iphone apple mobile'),
(10, 2, 6, 'Red Ladies dress', 1000, 'red dress for girls', 'red dress1026.jpg', 'red dress '),
(11, 2, 6, 'Blue Heave dress', 1200, 'Blue dress', 'images1126.jpg', 'blue dress cloths'),
(12, 2, 6, 'Ladies Casual Cloths', 1500, 'ladies casual summer two colors pleted', '7475-ladies-casual-dresses-summer-two-colors-pleated1226.jpg', 'girl dress cloths casual'),
(13, 2, 6, 'SpringAutumnDress', 1200, 'girls dress', 'Spring-Autumn-Winter-Young-Ladies-Casual-Wool-Dress-Women-s-One-Piece-Dresse-Dating-Clothes-Medium.jpg_640x6401326.jpg', 'girl dress'),
(14, 2, 6, 'Casual Dress', 1400, 'girl dress', 'download1426.jpg', 'ladies cloths girl'),
(15, 2, 6, 'Formal Look', 1500, 'girl dress', 'shutterstock1526_2036118191526.jpg', 'ladies wears dress girl'),
(16, 3, 6, 'Sweter for men', 600, '2012-Winter-Sweater-for-Men-for-better-outlook', '2012-Winter-Sweater-for-Men-for-better-outlook.jpg', 'black sweter cloth winter'),
(17, 3, 6, 'Gents formal', 1000, 'gents formal look', 'gents-formal-250x250.jpg', 'gents wear cloths'),
(19, 3, 6, 'Formal Coat', 3000, 'ad', 'images (1).jpg', 'coat blazer gents'),
(20, 3, 6, 'Mens Sweeter', 1600, 'jg', 'Winter-fashion-men-burst-sweater.png', 'sweeter gents '),
(21, 3, 6, 'T shirt', 800, 'ssds', 'IN-Mens-Apparel-Voodoo-Tiles-09._V333872612_.jpg', 'formal t shirt black'),
(22, 4, 6, 'Yellow T shirt ', 1300, 'yello t shirt with pant', '1.0x0.jpg', 'kids yellow t shirt'),
(23, 4, 6, 'Girls cloths', 1900, 'sadsf', 'GirlsClothing_Widgets2346.jpg', 'formal kids wear dress'),
(24, 4, 6, 'Blue T shirt', 700, 'g', 'images.jpg', 'kids dress'),
(25, 4, 6, 'Yellow girls dress', 750, 'as', 'images2546 (3).jpg', 'yellow kids dress'),
(27, 4, 6, 'Formal look', 690, 'sd', 'image28.jpg', 'formal kids dress'),
(32, 5, 0, 'Book Shelf', 2500, 'book shelf', 'furniture-book-shelf-250x250.jpg', 'book shelf furniture'),
(33, 6, 2, 'Refrigerator', 35000, 'Refrigerator', 'CT_WM_BTS-BTC-AppliancesHome_20150723.jpg', 'refrigerator samsung'),
(34, 6, 4, 'Emergency Light', 1000, 'Emergency Light', 'emergency light.JPG', 'emergency light'),
(35, 6, 0, 'Vaccum Cleaner', 6000, 'Vaccum Cleaner', 'images3560 (2).jpg', 'Vaccum Cleaner'),
(36, 6, 5, 'Iron', 1500, 'gj', 'iron.JPG', 'iron'),
(37, 6, 5, 'LED TV', 20000, 'LED TV', 'images (4).jpg', 'led tv lg'),
(38, 6, 4, 'Microwave Oven', 3500, 'Microwave Oven', 'images.jpg', 'Microwave Oven'),
(39, 6, 5, 'Mixer Grinder', 2500, 'Mixer Grinder', 'singer-mixer-grinder-mg-46-medium_4bfa018096c25dec7ba0af40662856ef.jpg', 'Mixer Grinder'),
(40, 2, 6, 'Formal girls dress', 3000, 'Formal girls dress', 'girl-walking4026.jpg', 'ladies'),
(45, 1, 2, 'Samsung Galaxy Note 3', 10000, '0', 'samsung_galaxy_note3_note3neo.JPG', 'samsung galaxy Note 3 neo'),
(46, 1, 2, 'Samsung Galaxy Note 3', 10000, '', 'samsung_galaxy_note3_note3neo.JPG', 'samsung galxaxy note 3 neo'),
(47, 4, 6, 'Laptop', 650, 'nbk', 'product01.png', 'Dell Laptop'),
(48, 1, 7, 'Headphones', 250, 'Headphones', 'product05.png', 'Headphones Sony'),
(49, 1, 7, 'Headphones', 250, 'Headphones', 'product05.png', 'Headphones Sony'),
(50, 3, 6, 'boys shirts', 350, 'shirts', 'pm1.JPG', 'suit boys shirts'),
(51, 3, 6, 'boys shirts', 270, 'shirts', 'pm2.JPG', 'suit boys shirts'),
(52, 3, 6, 'boys shirts', 453, 'shirts', 'pm3.JPG', 'suit boys shirts'),
(53, 3, 6, 'boys shirts', 220, 'shirts', 'ms1.JPG', 'suit boys shirts'),
(54, 3, 6, 'boys shirts', 290, 'shirts', 'ms2.JPG', 'suit boys shirts'),
(55, 3, 6, 'boys shirts', 259, 'shirts', 'ms3.JPG', 'suit boys shirts'),
(56, 3, 6, 'boys shirts', 299, 'shirts', 'pm7.JPG', 'suit boys shirts'),
(57, 3, 6, 'boys shirts', 260, 'shirts', 'i3.JPG', 'suit boys shirts'),
(58, 3, 6, 'boys shirts', 350, 'shirts', 'pm9.JPG', 'suit boys shirts'),
(59, 3, 6, 'boys shirts', 855, 'shirts', 'a2.JPG', 'suit boys shirts'),
(60, 3, 6, 'boys shirts', 150, 'shirts', 'pm11.JPG', 'suit boys shirts'),
(61, 3, 6, 'boys shirts', 215, 'shirts', 'pm12.JPG', 'suit boys shirts'),
(62, 3, 6, 'boys shirts', 299, 'shirts', 'pm13.JPG', 'suit boys shirts'),
(63, 3, 6, 'boys Jeans Pant', 550, 'Pants', 'pt1.JPG', 'boys Jeans Pant'),
(64, 3, 6, 'boys Jeans Pant', 460, 'pants', 'pt2.JPG', 'boys Jeans Pant'),
(65, 3, 6, 'boys Jeans Pant', 470, 'pants', 'pt3.JPG', 'boys Jeans Pant'),
(66, 3, 6, 'boys Jeans Pant', 480, 'pants', 'pt4.JPG', 'boys Jeans Pant'),
(67, 3, 6, 'boys Jeans Pant', 360, 'pants', 'pt5.JPG', 'boys Jeans Pant'),
(68, 3, 6, 'boys Jeans Pant', 550, 'pants', 'pt6.JPG', 'boys Jeans Pant'),
(69, 3, 6, 'boys Jeans Pant', 390, 'pants', 'pt7.JPG', 'boys Jeans Pant'),
(70, 3, 6, 'boys Jeans Pant', 399, 'pants', 'pt8.JPG', 'boys Jeans Pant'),
(71, 1, 2, 'Samsung galaxy s7', 5000, 'Samsung galaxy s7', 'product07.png', 'samsung mobile electronics'),
(72, 7, 2, 'sony Headphones', 3500, 'sony Headphones', 'product02.png', 'sony Headphones electronics gadgets'),
(73, 7, 2, 'samsung Headphones', 3500, 'samsung Headphones', 'product05.png', 'samsung Headphones electronics gadgets'),
(74, 1, 1, 'HP i5 laptop', 5500, 'HP i5 laptop', 'product01.png', 'HP i5 laptop electronics'),
(75, 1, 1, 'HP i7 laptop 8gb ram', 5500, 'HP i7 laptop 8gb ram', 'product03.png', 'HP i7 laptop 8gb ram electronics'),
(76, 1, 5, 'sony note 6gb ram', 4500, 'sony note 6gb ram', 'product04.png', 'sony note 6gb ram mobile electronics'),
(77, 1, 4, 'MSV laptop 16gb ram NVIDEA Graphics', 5499, 'MSV laptop 16gb ram', 'product06.png', 'MSV laptop 16gb ram NVIDEA Graphics electronics'),
(78, 1, 5, 'dell laptop 8gb ram intel integerated Graphics', 4579, 'dell laptop 8gb ram intel integerated Graphics', 'product08.png', 'dell laptop 8gb ram intel integerated Graphics electronics'),
(79, 7, 2, 'camera with 3D pixels', 2569, 'camera with 3D pixels', 'product09.png', 'camera with 3D pixels camera electronics gadgets'),
(80, 1, 1, 'ytrfdkjsd', 12343, 'sdfhgh', '1542455446_thythtf .jpeg', 'dfgh'),
(81, 4, 6, 'Kids blue dress', 300, 'blue dress', '1543993724_pg4.jpg', 'kids blue dress');

-- Table structure for user_info
CREATE TABLE dbo.user_info (
    user_id INT NOT NULL,
    first_name NVARCHAR(100) NOT NULL,
    last_name NVARCHAR(100) NOT NULL,
    email NVARCHAR(300) NOT NULL,
    password NVARCHAR(300) NOT NULL,
    mobile NVARCHAR(10) NOT NULL,
    address1 NVARCHAR(300) NOT NULL,
    address2 NVARCHAR(11) NOT NULL,
    PRIMARY KEY (user_id)
);

-- Insert data into user_info
INSERT INTO user_info (user_id, first_name, last_name, email, password, mobile, address1, address2)
VALUES
(12, 'Shohanur', 'Rahman', 'shohan@apricotstore.com', 'shohan', '9448121558', 'DSC', 'Dhaka'),
(15, 'Mehedi', 'Hasan', 'mehedi@apricotstore.com', 'mehedi', '536487276', ',DSC', 'Dhaka'),
(16, 'Asif', 'Rahman', 'asif@apricotstore.com', 'asif', '9877654334', 'DSC', 'Dhaka'),
(19, 'Niloy', 'Hasan', 'niloy@apricotstore.com', 'niloy', '9871236534', 'DSC', 'Dhaka'),
(21, 'Jony', 'Hasan', 'jony@apricotstore.com', 'jony', '202-555-01', 'DSC', 'Dhaka'),
(22, 'Maruf', 'Mia', 'maruf@apricotstore.com', 'maruf', '9877654334', 'DSC', 'Dhaka'),
(23, 'tausif', 'Mia', 'tausif@apricotstore.com', 'tausif', '9876543234', 'DSC', 'Dhaka'),
(24, 'limon', 'Sheikh', 'limon@apricotstore.com', 'limon', '9535688928', 'DSC', 'Dhaka'),
(25, 'rafin', 'Molla', 'rafin@apricotstore.com', 'rafin', '9535688928', 'DSC', 'Dhaka');
-- Trigger structure for user_info
CREATE TRIGGER after_user_info_insert ON dbo.user_info
AFTER INSERT
AS
BEGIN
    INSERT INTO user_info_backup (user_id, first_name, last_name, email, password, mobile, address1, address2)
    SELECT user_id, first_name, last_name, email, password, mobile, address1, address2 FROM inserted;
END;

-- Table structure for user_info_backup
CREATE TABLE user_info_backup (
    user_id INT NOT NULL IDENTITY(1,1),
    first_name NVARCHAR(100) NOT NULL,
    last_name NVARCHAR(100) NOT NULL,
    email NVARCHAR(300) NOT NULL,
    password NVARCHAR(300) NOT NULL,
    mobile NVARCHAR(10) NOT NULL,
    address1 NVARCHAR(300) NOT NULL,
    address2 NVARCHAR(11) NOT NULL,
    PRIMARY KEY (user_id)
);

-- Insert data into user_info_backup
INSERT INTO user_info_backup (first_name, last_name, email, password, mobile, address1, address2)
VALUES
('Shohanur', 'Rahman', 'shohan@apricotstore.com', 'shohan', '9448121558', 'DSC', 'Dhaka'),
('Mehedi', 'Hasan', 'mehedi@apricotstore.com', 'mehedi', '536487276', ',DSC', 'Dhaka'),
('Asif', 'Rahman', 'asif@apricotstore.com', 'asif', '9877654334', 'DSC', 'Dhaka'),
('Niloy', 'Hasan', 'niloy@apricotstore.com', 'niloy', '9871236534', 'DSC', 'Dhaka'),
('Jony', 'Hasan', 'jony@apricotstore.com', 'jony', '202-555-01', 'DSC', 'Dhaka'),
('Maruf', 'Mia', 'maruf@apricotstore.com', 'maruf', '9877654334', 'DSC', 'Dhaka'),
('tausif', 'Mia', 'tausif@apricotstore.com', 'tausif', '9876543234', 'DSC', 'Dhaka'),
('limon', 'Sheikh', 'limon@apricotstore.com', 'limon', '9535688928', 'DSC', 'Dhaka'),
('rafin', 'Molla', 'rafin@apricotstore.com', 'rafin', '9535688928', 'DSC', 'Dhaka');


--
-- Indexes for table `orders_info`
-- Indexes for orders_info table
CREATE INDEX idx_user_id_orders_info ON orders_info (user_id);

-- Indexes for order_products table
CREATE INDEX idx_order_id_order_products ON order_products (order_id);
CREATE INDEX idx_product_id_order_products ON order_products (product_id);

-- Indexes for products table
-- (If you want to add indexes, create them using the CREATE INDEX statement similar to above)

-- Indexes for user_info table
-- (If you want to add indexes, create them using the CREATE INDEX statement similar to above)

-- Indexes for user_info_backup table
-- (If you want to add indexes, create them using the CREATE INDEX statement similar to above)

-- AUTO_INCREMENT for dumped tables
-- (SQL Server uses IDENTITY for auto-increment)
-- Modify the table definitions accordingly

-- Constraints for orders_info table
ALTER TABLE orders_info
    ADD CONSTRAINT fk_user_id_orders_info FOREIGN KEY (user_id) REFERENCES user_info (user_id);

-- Constraints for order_products table
ALTER TABLE order_products
    ADD CONSTRAINT fk_order_id_order_products FOREIGN KEY (order_id) REFERENCES orders_info (order_id) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE order_products
    ADD CONSTRAINT fk_product_id_order_products FOREIGN KEY (product_id) REFERENCES products (product_id);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
