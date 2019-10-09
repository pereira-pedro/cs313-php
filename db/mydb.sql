
CREATE TABLE customer
(
  id SERIAL PRIMARY KEY,
  name VARCHAR(128) NOT NULL,
  email VARCHAR(128) NOT NULL,
  password VARCHAR(64) NOT NULL,
  salt VARCHAR(32) NOT NULL
);

CREATE TABLE product
(
  id SERIAL PRIMARY KEY,
  name VARCHAR(128) NOT NULL,
  description JSON NOT NULL,
  stock INTEGER NOT NULL,
  price REAL NOT NULL,
  discount_rate REAL NOT NULL,
  tax_rate REAL NOT NULL
);

CREATE TABLE product_image
(
  id SERIAL PRIMARY KEY,
  id_product INTEGER NOT NULL,
  title VARCHAR(128) NOT NULL,
  url VARCHAR(256) NOT NULL,
  CONSTRAINT product_image_product_fk1 FOREIGN KEY (id_product)
      REFERENCES product (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE public.order
(
  id SERIAL PRIMARY KEY,
  id_customer INTEGER NOT NULL,
  date_ordered TIMESTAMPTZ NOT NULL DEFAULT NOW(),
  date_shipped TIMESTAMPTZ,
  date_received TIMESTAMPTZ,
  CONSTRAINT order_customer_fk1 FOREIGN KEY (id_customer)
      REFERENCES customer (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE order_item
(
  id SERIAL PRIMARY KEY,
  id_order INTEGER NOT NULL,
  id_product INTEGER NOT NULL,
  quantity INTEGER NOT NULL,
  price REAL NOT NULL,
  discount REAL NOT NULL,
  tax REAL NOT NULL,
  CONSTRAINT order_item_product_fk1 FOREIGN KEY (id_product)
      REFERENCES product (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT order_item_order_fk1 FOREIGN KEY (id_order)
      REFERENCES public.order (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);