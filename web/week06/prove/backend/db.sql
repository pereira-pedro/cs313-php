CREATE TABLE public.product
(
    id integer NOT NULL DEFAULT nextval('product_id_seq'::regclass),
    title character varying(128) COLLATE pg_catalog."default" NOT NULL,
    description json NOT NULL,
    stock integer NOT NULL,
    price real NOT NULL,
    discount_rate real NOT NULL,
    tax_rate real NOT NULL,
    rating integer,
    CONSTRAINT product_pkey PRIMARY KEY (id)
);

CREATE TABLE public.customer
(
    id integer NOT NULL DEFAULT nextval('customer_id_seq'::regclass),
    name character varying(128) COLLATE pg_catalog."default" NOT NULL,
    email character varying(128) COLLATE pg_catalog."default" NOT NULL,
    password character varying(64) COLLATE pg_catalog."default" NOT NULL,
    salt character varying(32) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT customer_pkey PRIMARY KEY (id)
);

CREATE TABLE public."order"
(
    id integer NOT NULL DEFAULT nextval('order_id_seq'::regclass),
    id_customer integer NOT NULL,
    date_ordered timestamp with time zone NOT NULL DEFAULT now(),
    date_shipped timestamp with time zone,
    date_received timestamp with time zone,
    CONSTRAINT order_pkey PRIMARY KEY (id),
    CONSTRAINT order_customer_fk1 FOREIGN KEY (id_customer)
        REFERENCES public.customer (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

CREATE TABLE public.order_item
(
    id integer NOT NULL DEFAULT nextval('order_item_id_seq'::regclass),
    id_order integer NOT NULL,
    id_product integer NOT NULL,
    quantity integer NOT NULL,
    price real NOT NULL,
    discount real NOT NULL,
    tax real NOT NULL,
    CONSTRAINT order_item_pkey PRIMARY KEY (id),
    CONSTRAINT order_item_order_fk1 FOREIGN KEY (id_order)
        REFERENCES public."order" (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT order_item_product_fk1 FOREIGN KEY (id_product)
        REFERENCES public.product (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

CREATE TABLE public.product_image
(
    id integer NOT NULL DEFAULT nextval('product_image_id_seq'::regclass),
    id_product integer NOT NULL,
    title character varying(128) COLLATE pg_catalog."default" NOT NULL,
    url character varying(256) COLLATE pg_catalog."default" NOT NULL,
    main boolean NOT NULL DEFAULT true,
    CONSTRAINT product_image_pkey PRIMARY KEY (id),
    CONSTRAINT product_image_product_fk1 FOREIGN KEY (id_product)
        REFERENCES public.product (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE SEQUENCE public.customer_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

CREATE SEQUENCE public.order_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

CREATE SEQUENCE public.order_item_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

CREATE SEQUENCE public.product_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;            

CREATE SEQUENCE public.product_image_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;    