PGDMP                          x            stats    13.1    13.1 $    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16395    stats    DATABASE     b   CREATE DATABASE stats WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'Russian_Russia.1251';
    DROP DATABASE stats;
                postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
                postgres    false            �           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                   postgres    false    3            �            1259    16553 	   event_seq    SEQUENCE     y   CREATE SEQUENCE public.event_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;
     DROP SEQUENCE public.event_seq;
       public          postgres    false    3            �            1259    16495    event    TABLE     �   CREATE TABLE public.event (
    id integer DEFAULT nextval('public.event_seq'::regclass) NOT NULL,
    event_name character varying(255) NOT NULL
);
    DROP TABLE public.event;
       public         heap    postgres    false    206    3            �            1259    16564    events_data_seq    SEQUENCE        CREATE SEQUENCE public.events_data_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;
 &   DROP SEQUENCE public.events_data_seq;
       public          postgres    false    3            �            1259    16530    events_data    TABLE       CREATE TABLE public.events_data (
    id integer DEFAULT nextval('public.events_data_seq'::regclass) NOT NULL,
    date integer NOT NULL,
    system_id integer NOT NULL,
    event_id integer NOT NULL,
    user_id integer NOT NULL,
    iogv_id integer NOT NULL,
    info_id integer
);
    DROP TABLE public.events_data;
       public         heap    postgres    false    211    3            �            1259    16562    info_seq    SEQUENCE     x   CREATE SEQUENCE public.info_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;
    DROP SEQUENCE public.info_seq;
       public          postgres    false    3            �            1259    16543    info    TABLE     �   CREATE TABLE public.info (
    id integer DEFAULT nextval('public.info_seq'::regclass) NOT NULL,
    info_value json NOT NULL
);
    DROP TABLE public.info;
       public         heap    postgres    false    210    3            �            1259    16560    iogv_seq    SEQUENCE     x   CREATE SEQUENCE public.iogv_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;
    DROP SEQUENCE public.iogv_seq;
       public          postgres    false    3            �            1259    16505    iogv    TABLE     �   CREATE TABLE public.iogv (
    id integer DEFAULT nextval('public.iogv_seq'::regclass) NOT NULL,
    iogv_name character varying(255) NOT NULL
);
    DROP TABLE public.iogv;
       public         heap    postgres    false    209    3            �            1259    16558 
   system_seq    SEQUENCE     z   CREATE SEQUENCE public.system_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;
 !   DROP SEQUENCE public.system_seq;
       public          postgres    false    3            �            1259    16515    system    TABLE     �   CREATE TABLE public.system (
    id integer DEFAULT nextval('public.system_seq'::regclass) NOT NULL,
    system_name character varying(255) NOT NULL
);
    DROP TABLE public.system;
       public         heap    postgres    false    208    3            �            1259    16556    user_seq    SEQUENCE     x   CREATE SEQUENCE public.user_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;
    DROP SEQUENCE public.user_seq;
       public          postgres    false    3            �            1259    16535    user    TABLE       CREATE TABLE public."user" (
    id integer DEFAULT nextval('public.user_seq'::regclass) NOT NULL,
    login character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    lastname character varying(255) NOT NULL,
    patronymic character varying(255) NOT NULL
);
    DROP TABLE public."user";
       public         heap    postgres    false    207    3            �          0    16495    event 
   TABLE DATA           /   COPY public.event (id, event_name) FROM stdin;
    public          postgres    false    200   �#       �          0    16530    events_data 
   TABLE DATA           _   COPY public.events_data (id, date, system_id, event_id, user_id, iogv_id, info_id) FROM stdin;
    public          postgres    false    203    $       �          0    16543    info 
   TABLE DATA           .   COPY public.info (id, info_value) FROM stdin;
    public          postgres    false    205   $       �          0    16505    iogv 
   TABLE DATA           -   COPY public.iogv (id, iogv_name) FROM stdin;
    public          postgres    false    201   :$       �          0    16515    system 
   TABLE DATA           1   COPY public.system (id, system_name) FROM stdin;
    public          postgres    false    202   W$       �          0    16535    user 
   TABLE DATA           G   COPY public."user" (id, login, name, lastname, patronymic) FROM stdin;
    public          postgres    false    204   t$       �           0    0 	   event_seq    SEQUENCE SET     7   SELECT pg_catalog.setval('public.event_seq', 1, true);
          public          postgres    false    206            �           0    0    events_data_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.events_data_seq', 1, true);
          public          postgres    false    211            �           0    0    info_seq    SEQUENCE SET     7   SELECT pg_catalog.setval('public.info_seq', 1, false);
          public          postgres    false    210            �           0    0    iogv_seq    SEQUENCE SET     6   SELECT pg_catalog.setval('public.iogv_seq', 1, true);
          public          postgres    false    209            �           0    0 
   system_seq    SEQUENCE SET     8   SELECT pg_catalog.setval('public.system_seq', 1, true);
          public          postgres    false    208            �           0    0    user_seq    SEQUENCE SET     6   SELECT pg_catalog.setval('public.user_seq', 1, true);
          public          postgres    false    207            I           2606    16499    event event_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.event
    ADD CONSTRAINT event_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.event DROP CONSTRAINT event_pkey;
       public            postgres    false    200            O           2606    16534    events_data events_data_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.events_data
    ADD CONSTRAINT events_data_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.events_data DROP CONSTRAINT events_data_pkey;
       public            postgres    false    203            S           2606    16550    info info_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.info
    ADD CONSTRAINT info_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.info DROP CONSTRAINT info_pkey;
       public            postgres    false    205            K           2606    16509    iogv iogv_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.iogv
    ADD CONSTRAINT iogv_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.iogv DROP CONSTRAINT iogv_pkey;
       public            postgres    false    201            M           2606    16519    system system_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.system
    ADD CONSTRAINT system_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.system DROP CONSTRAINT system_pkey;
       public            postgres    false    202            Q           2606    16542    user user_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public."user" DROP CONSTRAINT user_pkey;
       public            postgres    false    204            �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �     