PGDMP             
            x            stats    13.1    13.1     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16395    stats    DATABASE     b   CREATE DATABASE stats WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'Russian_Russia.1251';
    DROP DATABASE stats;
                postgres    false            �            1259    16441    info    TABLE     �   CREATE TABLE public.info (
    id integer DEFAULT nextval('public.info_seq'::regclass) NOT NULL,
    event_id integer NOT NULL,
    name character varying(255) NOT NULL,
    value character varying(255) NOT NULL
);
    DROP TABLE public.info;
       public         heap    postgres    false            �          0    16441    info 
   TABLE DATA           9   COPY public.info (id, event_id, name, value) FROM stdin;
    public          postgres    false    202   h       *           2606    16448    info info_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.info
    ADD CONSTRAINT info_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.info DROP CONSTRAINT info_pkey;
       public            postgres    false    202            �   J   x���4405�L.-.���,I-.I-Ⲅ������Ƨe��pf���$�(d���&�d��q��qqq 	��     