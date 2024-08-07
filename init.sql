create sequence id_seq
    as integer
    maxvalue 10000;

alter sequence id_seq owner to postgres;

create table if not exists urls
(
    id            integer default nextval('id_seq'::regclass) not null
        constraint urls_pk
            primary key,
    base_url      text                                        not null
        constraint urls_pk_base_rul
            unique,
    shortened_url text                                        not null
);

alter table urls
    owner to postgres;

create index if not exists urls_base_index
    on urls (base_url);

create index if not exists urls_shortened_index
    on urls (shortened_url);

