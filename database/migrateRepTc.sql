
CreateReptcsTable: create table PARC.reptcs ( 
                        id number(19,0) not null, 
                        numerotc varchar2(12) not null, 
                        codeparc varchar2(12) not null, 
                        daterecep date not null, 
                        debutrep date not null, 
                        finrep date not null, 
                        obs varchar2(255) not null, 
                        cout number(8, 2) not null, 
                        prepasurf char(1) default '0' not null, 
                        created_by number(19,0) null, 
                        updated_by number(19,0) null, 
                        deleted_by number(19,0) null, 
                        created_at timestamp null, 
                        updated_at timestamp null, 
                        deleted_at timestamp null, 
                        constraint reptcs_created_by_fk 
                            foreign key ( created_by ) 
                            references booking.users ( id ), 
                        constraint reptcs_updated_by_fk 
                            foreign key ( updated_by ) 
                            references booking.users ( id ), 
                        constraint reptcs_deleted_by_fk 
                            foreign key ( deleted_by ) 
                            references booking.users ( id ), 
                        constraint reptcs_id_pk primary key ( id ) 
                    )
CreateReptcsTable: create sequence PARC.reptcs_id_seq minvalue 1  start with 1 increment by 1 
CreateReptcsTable: 
            create trigger PARC.reptcs_id_trg
            before insert on PARC.REPTCS
            for each row
                begin
            if :new.ID is null then
                select PARC.reptcs_id_seq.nextval into :new.ID from dual;
            end if;
            end;
CreateReptcActionsTable: create table PARC.reptc_actions ( 
                            id varchar2(12) not null, 
                            libelle varchar2(40) not null, 
                            enabled char(1) default '1' not null, 
                            created_by number(19,0) null, 
                            updated_by number(19,0) null, 
                            deleted_by number(19,0) null, 
                            created_at timestamp null, 
                            updated_at timestamp null, 
                            deleted_at timestamp null, 
                            constraint reptc_actions_created_by_fk 
                                foreign key ( created_by ) 
                                references booking.users ( id ), 
                            constraint reptc_actions_updated_by_fk 
                                foreign key ( updated_by ) 
                                references booking.users ( id ), 
                            constraint reptc_actions_deleted_by_fk 
                                foreign key ( deleted_by ) 
                                references booking.users ( id ), 
                            constraint reptc_actions_id_pk primary key ( id ) 
                        )
CreateReptcSidesTable: create table PARC.reptc_sides ( 
                            id varchar2(12) not null, 
                            libelle varchar2(40) not null, 
                            enabled char(1) default '1' not null, 
                            created_by number(19,0) null, 
                            updated_by number(19,0) null, 
                            deleted_by number(19,0) null, 
                            created_at timestamp null, 
                            updated_at timestamp null, 
                            deleted_at timestamp null, 
                            constraint reptc_sides_created_by_fk 
                                foreign key ( created_by ) 
                                references booking.users ( id ), 
                            constraint reptc_sides_updated_by_fk 
                                foreign key ( updated_by ) 
                                references booking.users ( id ), 
                            constraint reptc_sides_deleted_by_fk 
                                foreign key ( deleted_by ) 
                                references booking.users ( id ), 
                            constraint reptc_sides_id_pk primary key ( id ) 
                        );

CreateReptcEmployeTable: create table PARC.reptc_employe ( 
                            reptc_id number(19,0) not null, 
                            reptc_agent_code varchar2(20) not null, 
                            constraint reptc_employe_reptc_id_fk 
                                foreign key ( reptc_id ) 
                                references PARC.reptcs ( id ), 
                            constraint reptc_employe_reptc_agent_code_fk 
                                foreign key ( reptc_agent_code ) 
                                references EOLIS.employe ( code_emp ), 
                            constraint rep_emplo_rep_id_rep_age_co_pk primary key ( reptc_id, reptc_agent_code ) 
                        )

CreateReptcPieceTable: create table PARC.reptc_piece ( 
                            reptc_id number(19,0) not null, 
                            idpiece number(10,0) not null, 
                            codeunite varchar2(2) not null, 
                            pu number(19,0) not null, 
                            qte number(19,0) not null, 
                            constraint reptc_piece_reptc_id_fk 
                                foreign key ( reptc_id ) 
                                references PARC.reptcs ( id ), 
                            constraint reptc_piece_idpiece_fk 
                                foreign key ( idpiece ) 
                                references PARC.piece ( idpiece ), 
                            constraint reptc_piece_codeunite_fk 
                                foreign key ( codeunite ) 
                                references PARC.unite ( codeunite ), 
                            constraint rep_piece_rep_id_idpiece_pk primary key ( reptc_id, idpiece ) 
                        );

CreateReptcReptcSideTable: create table PARC.reptc_reptc_side ( 
                            reptc_id number(19,0) not null, 
                            reptc_side_id varchar2(20) not null, 
                            reptc_action_id varchar2(20) not null, 
                            constat varchar2(255) null, 
                            constraint reptc_rside_reptc_id_fk 
                                foreign key ( reptc_id ) 
                                references PARC.reptcs ( id ), 
                            constraint reptc_rside_reptc_side_id_fk 
                                foreign key ( reptc_side_id ) 
                                references PARC.reptc_sides ( id ), 
                            constraint reptc_rside_reptc_action_id_fk 
                                foreign key ( reptc_action_id ) 
                                references PARC.reptc_actions ( id ), 
                            constraint rep_rep_side_pk primary key ( reptc_id, reptc_side_id, reptc_action_id ) 
                        );

CreateBatteriesTable: create table PARC.batteries ( 
                            id number(19,0) not null, 
                            idpiece number(10,0) not null, 
                            libelle varchar2(10) not null, 
                            enabled char(1) default '1' not null, 
                            created_by number(19,0) null, 
                            updated_by number(19,0) null, 
                            deleted_by number(19,0) null, 
                            created_at timestamp null, 
                            updated_at timestamp null, 
                            deleted_at timestamp null, 
                            constraint batteries_idpiece_fk 
                                foreign key ( idpiece ) 
                                references PARC.piece ( idpiece ), 
                            constraint batteries_created_by_fk 
                                foreign key ( created_by ) 
                                references booking.users ( id ), 
                            constraint batteries_updated_by_fk 
                                foreign key ( updated_by ) 
                                references booking.users ( id ), 
                            constraint batteries_deleted_by_fk 
                                foreign key ( deleted_by ) 
                                references booking.users ( id ), 
                            constraint batteries_id_pk primary key ( id ) 
                        );
CreateBatteriesTable: create unique index batteries_libelle_uk on PARC.batteries (lower(libelle));
CreateBatteriesTable: create sequence PARC.batteries_id_seq minvalue 1  start with 1 increment by 1;
CreateBatteriesTable: 
            create trigger PARC.batteries_id_trg
            before insert on PARC.BATTERIES
            for each row
            begin
            if :new.ID is null then
                select PARC.batteries_id_seq.nextval into :new.ID from dual;
            end if;
            end;

CreatePrisesTable: create table PARC.prises ( 
                        id number(19,0) not null, 
                        libelle varchar2(10) not null, 
                        enabled char(1) default '1' not null, 
                        created_by number(19,0) null, 
                        updated_by number(19,0) null, 
                        deleted_by number(19,0) null, 
                        created_at timestamp null, 
                        updated_at timestamp null, 
                        deleted_at timestamp null, 
                        constraint prises_created_by_fk 
                            foreign key ( created_by ) 
                            references booking.users ( id ), 
                        constraint prises_updated_by_fk 
                            foreign key ( updated_by ) 
                            references booking.users ( id ), 
                        constraint prises_deleted_by_fk 
                            foreign key ( deleted_by ) 
                            references booking.users ( id ), 
                        constraint prises_id_pk primary key ( id ) 
                    );
CreatePrisesTable: create unique index prises_libelle_uk on PARC.prises (lower(libelle));
CreatePrisesTable: create sequence PARC.prises_id_seq minvalue 1  start with 1 increment by 1; 
CreatePrisesTable: 
            create trigger PARC.prises_id_trg
            before insert on PARC.PRISES
            for each row
                begin
            if :new.ID is null then
                select PARC.prises_id_seq.nextval into :new.ID from dual;
            end if;
            end;

CreateBatteriePrisesTable: create table PARC.batterie_prise ( 
                                batterie_id number(19,0) not null, 
                                prise_id number(19,0) not null, 
                                debut date null, 
                                fin date null, 
                                observation varchar2(255) null, 
                                created_by number(19,0) null, 
                                updated_by number(19,0) null, 
                                constraint batterie_prise_batterie_id_fk 
                                    foreign key ( batterie_id ) 
                                    references PARC.batteries ( id ), 
                                constraint batterie_prise_prise_id_fk 
                                    foreign key ( prise_id ) 
                                    references PARC.prises ( id ), 
                                constraint batterie_prise_created_by_fk 
                                    foreign key ( created_by ) 
                                    references booking.users ( id ), 
                                constraint batterie_prise_updated_by_fk 
                                    foreign key ( updated_by ) 
                                    references booking.users ( id ), 
                                constraint batter_pri_batter_id_pri_id_pk primary key ( batterie_id, prise_id, debut ) 
                            );

CreateBatterieEnginTable: create table PARC.batterie_engin ( 
                                batterie_id number(19,0) not null, 
                                idengin varchar2(7) not null, 
                                debut date null, 
                                fin date null, 
                                observation varchar2(255) null, 
                                created_by number(19,0) null, 
                                updated_by number(19,0) null, 
                                constraint batterie_engin_batterie_id_fk 
                                    foreign key ( batterie_id ) 
                                    references PARC.batteries ( id ), 
                                constraint batterie_engin_idengin_id_fk 
                                    foreign key ( idengin ) 
                                    references PARC.engin ( idengin ), 
                                constraint batterie_engin_created_by_fk 
                                    foreign key ( created_by ) 
                                    references booking.users ( id ), 
                                constraint batterie_engin_updated_by_fk 
                                    foreign key ( updated_by ) 
                                    references booking.users ( id ), 
                                constraint batter_eng_batter_id_ideng_pk primary key ( batterie_id, idengin, debut ) 
                            );


CreateChargeursTable: create table PARC.chargeurs ( 
                        id number(19,0) not null, 
                        libelle varchar2(10) not null, 
                        enabled char(1) default '1' not null, 
                        created_by number(19,0) null, 
                        updated_by number(19,0) null, 
                        deleted_by number(19,0) null, 
                        created_at timestamp null, 
                        updated_at timestamp null, 
                        deleted_at timestamp null, 
                        constraint chargeurs_created_by_fk 
                            foreign key ( created_by ) 
                            references booking.users ( id ), 
                        constraint chargeurs_updated_by_fk 
                            foreign key ( updated_by ) 
                            references booking.users ( id ), 
                        constraint chargeurs_deleted_by_fk 
                            foreign key ( deleted_by ) 
                            references booking.users ( id ), 
                        constraint chargeurs_id_pk primary key ( id ) 
                    );
CreateChargeursTable: create unique index chargeurs_libelle_uk on PARC.chargeurs (lower(libelle));
CreateChargeursTable: create sequence PARC.chargeurs_id_seq minvalue 1  start with 1 increment by 1; 
CreateChargeursTable: 
            create trigger PARC.chargeurs_id_trg
            before insert on PARC.PRISES
            for each row
                begin
            if :new.ID is null then
                select PARC.chargeurs_id_seq.nextval into :new.ID from dual;
            end if;
            end;


CreateBatteriePrisesTable: create table PARC.batterie_reception ( 
                                batterie_id number(19,0) not null, 
                                mod_docker_matricule varchar2(5) not null, 
                                date_reception date not null, 
                                observation varchar2(255) null, 
                                created_by number(19,0) null, 
                                updated_by number(19,0) null, 
                                constraint batterie_reception_batterie_id_fk 
                                    foreign key ( batterie_id ) 
                                    references PARC.batteries ( id ), 
                                constraint batterie_reception_mod_docker_matricule_fk 
                                    foreign key ( mod_docker_matricule ) 
                                    references ACCONAGE.mod_dockers ( matricule ), 
                                constraint batterie_reception_created_by_fk 
                                    foreign key ( created_by ) 
                                    references booking.users ( id ), 
                                constraint batterie_reception_updated_by_fk 
                                    foreign key ( updated_by ) 
                                    references booking.users ( id ), 
                                constraint batter_recep_batter_id_matricule_pk primary key ( batterie_id, mod_docker_matricule, date_reception ) 
                            );



