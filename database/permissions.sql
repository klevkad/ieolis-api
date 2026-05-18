# Menus
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('menuexport', 'Menu Export', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'menuimport', 'Menu Import', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'menufichier', 'Menu Fichiers', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'menuarchive', 'Menu Archives', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'menufacturation', 'Menu Facturation', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'menugestion', 'Menu Gestion Administrative', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'menutracking', 'Menu Tracking', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'menuparc', 'Menu Gestion de Parc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'menuqualite', 'Menu Qualité', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'menutransit', 'Menu Transit', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'menuquota', 'Menu Quota', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'menusynthese', 'Menu Synthèses', 'api', now(), now());



# F_Comptet
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('fcomptetfilter', 'filtrer la liste des comptes tiers', 'api', now(), now());



# AttributionClipon
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('attributioncliponfilter', 'filtrer la liste des attributions de clipons', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponpaginate', 'paginer la liste des attributions de clipons', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponindex', 'afficher la liste des attributions de clipons', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponcreate', 'créer une attribution de clipon', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponshow', 'afficher le détail d\'une attribution de clipon', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponupdate', 'modifier une attribution de clipon', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributionclipondelete', 'supprimer une attribution de clipon', 'api', now(), now());

# AttributionCliponRetour
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('attributioncliponretourfilter', 'filtrer la liste des attributions de clipons au retour', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponretourpaginate', 'paginer la liste des attributions de clipons au retour', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponretourindex', 'afficher la liste des attributions de clipons au retour', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponretourcreate', 'créer une attribution de clipon au retour', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponretourshow', 'afficher le détail d\'une attribution de clipon au retour', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponretourupdate', 'modifier une attribution de clipon au retour', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponretourdelete', 'supprimer une attribution de clipon au retour', 'api', now(), now());

# AttributionCliponRetourVerif
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('attributioncliponretourveriffilter', 'filtrer la liste des vérifications de clipons attribués au retour', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponretourverifpaginate', 'paginer la liste des vérifications de clipons attribués au retour', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponretourverifindex', 'afficher la liste des vérifications de clipons attribués au retour', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponretourverifcreate', 'créer une vérification de clipon attribué au retour', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponretourverifshow', 'afficher le détail d\'une vérification de clipon attribué au retour', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponretourverifupdate', 'modifier une vérification de clipon attribué au retour', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponretourverifdelete', 'supprimer une vérification de clipon attribué au retour', 'api', now(), now());

# AttributionCliponVerif
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('attributioncliponveriffilter', 'filtrer la liste des vérifications de clipons attribués', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponverifpaginate', 'paginer la liste des vérifications de clipons attribués', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponverifindex', 'afficher la liste des vérifications de clipons attribués', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponverifcreate', 'créer une vérification de clipon attribué', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponverifshow', 'afficher le détail d\'une vérification de clipon attribué', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponverifupdate', 'modifier une vérification de clipon attribué', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributioncliponverifdelete', 'supprimer une vérification de clipon attribué', 'api', now(), now());

# AttributionTc
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('attributiontcfilter', 'filtrer la liste des attributions tcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributiontcpaginate', 'paginer la liste des attributions tcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributiontcindex', 'afficher la liste des attributions tcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributiontccreate', 'créer une attribution tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributiontcshow', 'afficher le détail d\'une attribution tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributiontcupdate', 'modifier une attribution tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'attributiontcdelete', 'supprimer une attribution tc', 'api', now(), now());

# BookingTc
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('bookingtcfilter', 'filtrer la liste des bookings tcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'bookingtcpaginate', 'paginer la liste des bookings tcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'bookingtcindex', 'afficher la liste des bookings tcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'bookingtccreate', 'créer un booking tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'bookingtcshow', 'afficher le détail d\'un booking tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'bookingtcupdate', 'modifier un booking tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'bookingtcdelete', 'supprimer un booking tc', 'api', now(), now());

# BookingTcFinal
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('bookingtcfinalfilter', 'filtrer la liste des bookings tcs finaux', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'bookingtcfinalpaginate', 'paginer la liste des bookings tcs finaux', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'bookingtcfinalindex', 'afficher la liste des bookings tcs finaux', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'bookingtcfinalcreate', 'créer un booking tc final', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'bookingtcfinalshow', 'afficher le détail d\'un booking tc final', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'bookingtcfinalupdate', 'modifier un booking tc final', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'bookingtcfinaldelete', 'supprimer un booking tc final', 'api', now(), now());

# DemandeBooking
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('demandebookingfilter', 'filtrer la liste des demandes de bookings', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'demandebookingpaginate', 'paginer la liste des demandes de bookings', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'demandebookingindex', 'afficher la liste des demandes de bookings', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'demandebookingcreate', 'créer une demande de booking', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'demandebookingshow', 'afficher le détail d\'une demande de booking', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'demandebookingupdate', 'modifier une demande de booking', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'demandebookingdelete', 'supprimer une demande de booking', 'api', now(), now());

# EmbarquementTc
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('embarquementtcfilter', 'filtrer la liste des tcs embarqués', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'embarquementtcpaginate', 'paginer la liste des tcs embarqués', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'embarquementtcindex', 'afficher la liste des tcs embarqués', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'embarquementtccreate', 'créer un embarquement tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'embarquementtcshow', 'afficher le détail d\'un embarquement tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'embarquementtcupdate', 'modifier un embarquement tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'embarquementtcdelete', 'supprimer un embarquement tc', 'api', now(), now());

# EmpotageTcPosit
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('empotagetcpositfilter', 'filtrer la liste des empotages de tcs positionnés', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'empotagetcpositpaginate', 'paginer la liste des empotages de tcs positionnés', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'empotagetcpositindex', 'afficher la liste des empotages de tcs positionnés', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'empotagetcpositcreate', 'créer un empotage de tc positionné', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'empotagetcpositshow', 'afficher le détail d\'un empotage de tc positionné', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'empotagetcpositupdate', 'modifier un empotage de tc positionné', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'empotagetcpositdelete', 'supprimer un empotage de tc positionné', 'api', now(), now());

# FinPositCliponVerif
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('finpositcliponveriffilter', 'filtrer la liste des finpositcliponverifs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finpositcliponverifpaginate', 'paginer la liste des finpositcliponverifs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finpositcliponverifindex', 'afficher la liste des finpositcliponverifs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finpositcliponverifcreate', 'créer un finpositcliponverif', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finpositcliponverifshow', 'afficher le détail d\'un finpositcliponverif', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finpositcliponverifupdate', 'modifier un finpositcliponverif', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finpositcliponverifdelete', 'supprimer un finpositcliponverif', 'api', now(), now());

# FinPositTc
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('finposittcfilter', 'filtrer la liste des finposittcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finposittcpaginate', 'paginer la liste des finposittcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finposittcindex', 'afficher la liste des finposittcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finposittccreate', 'créer une finposittc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finposittcshow', 'afficher le détail d\'une finposittc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finposittcupdate', 'modifier une finposittc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finposittcdelete', 'supprimer une finposittc', 'api', now(), now());

# FinRetourCliponVerif
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('finretourcliponveriffilter', 'filtrer la liste des finretourcliponverifs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finretourcliponverifpaginate', 'paginer la liste des finretourcliponverifs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finretourcliponverifindex', 'afficher la liste des finretourcliponverifs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finretourcliponverifcreate', 'créer une finretourcliponverif', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finretourcliponverifshow', 'afficher le détail d\'une finretourcliponverif', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finretourcliponverifupdate', 'modifier une finretourcliponverif', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finretourcliponverifdelete', 'supprimer une finretourcliponverif', 'api', now(), now());

# FinRetourTc
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('finretourtcfilter', 'filtrer la liste des finretourtcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finretourtcpaginate', 'paginer la liste des finretourtcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finretourtcindex', 'afficher la liste des finretourtcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finretourtccreate', 'créer une finretourtc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finretourtcshow', 'afficher le détail d\'une finretourtc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finretourtcupdate', 'modifier une finretourtc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'finretourtcdelete', 'supprimer une finretourtc', 'api', now(), now());

# MotifRefusBooking
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('motifrefusbookingfilter', 'filtrer la liste des motifs de refus de bookings', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'motifrefusbookingpaginate', 'paginer la liste des motifs de refus de bookings', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'motifrefusbookingindex', 'afficher la liste des motifs de refus de bookings', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'motifrefusbookingcreate', 'créer un motif de refus de booking', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'motifrefusbookingshow', 'afficher le détail d\'un motif de refus de booking', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'motifrefusbookingupdate', 'modifier un motif de refus de booking', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'motifrefusbookingdelete', 'supprimer un motif de refus de booking', 'api', now(), now());

# ParamTcReefer
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('paramtcreeferfilter', 'filtrer la liste des paramtcreefers', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'paramtcreeferpaginate', 'paginer la liste des paramtcreefers', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'paramtcreeferindex', 'afficher la liste des paramtcreefers', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'paramtcreefercreate', 'créer un paramtcreefer', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'paramtcreefershow', 'afficher le détail d\'un paramtcreefer', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'paramtcreeferupdate', 'modifier un paramtcreefer', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'paramtcreeferdelete', 'supprimer un paramtcreefer', 'api', now(), now());

# PositionnementTc
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('positionnementtcfilter', 'filtrer la liste des positionnements tcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'positionnementtcpaginate', 'paginer la liste des positionnements tcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'positionnementtcindex', 'afficher la liste des positionnements tcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'positionnementtccreate', 'créer un positionnement tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'positionnementtcshow', 'afficher le détail d\'un positionnement tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'positionnementtcupdate', 'modifier un positionnement tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'positionnementtcdelete', 'supprimer un positionnement tc', 'api', now(), now());

# PositionnementTcPropreMoyen
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('positionnementtcpropremoyenfilter', 'filtrer la liste des positionnementtcpropremoyens', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'positionnementtcpropremoyenpaginate', 'paginer la liste des positionnementtcpropremoyens', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'positionnementtcpropremoyenindex', 'afficher la liste des positionnementtcpropremoyens', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'positionnementtcpropremoyencreate', 'créer un positionnementtcpropremoyen', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'positionnementtcpropremoyenshow', 'afficher le détail d\'un positionnementtcpropremoyen', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'positionnementtcpropremoyenupdate', 'modifier un positionnementtcpropremoyen', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'positionnementtcpropremoyendelete', 'supprimer un positionnementtcpropremoyen', 'api', now(), now());

# RetourTc
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('retourtcfilter', 'filtrer la liste des retourtcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'retourtcpaginate', 'paginer la liste des retourtcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'retourtcindex', 'afficher la liste des retourtcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'retourtccreate', 'créer une retourtc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'retourtcshow', 'afficher le détail d\'une retourtc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'retourtcupdate', 'modifier une retourtc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'retourtcdelete', 'supprimer une retourtc', 'api', now(), now());



# Activite
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('activitefilter', 'filtrer la liste des activités', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'activitepaginate', 'paginer la liste des activités', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'activiteindex', 'afficher la liste des activités', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'activitecreate', 'créer une activité', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'activiteshow', 'afficher le détail d\'une activité', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'activiteupdate', 'modifier une activité', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'activitedelete', 'supprimer une activité', 'api', now(), now());

# Chauffeur
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('chauffeurfilter', 'filtrer la liste des chauffeurs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'chauffeurpaginate', 'paginer la liste des chauffeurs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'chauffeurindex', 'afficher la liste des chauffeurs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'chauffeurcreate', 'créer un chauffeur', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'chauffeurshow', 'afficher le détail d\'un chauffeur', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'chauffeurupdate', 'modifier un chauffeur', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'chauffeurdelete', 'supprimer un chauffeur', 'api', now(), now());

# EtapeSuiviBooking
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('etapesuivibookingfilter', 'filtrer la liste des etapes de suivi d\'un booking', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'etapesuivibookingpaginate', 'paginer la liste des etapes de suivi d\'un booking', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'etapesuivibookingindex', 'afficher la liste des etapes de suivi d\'un booking', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'etapesuivibookingcreate', 'créer une etape de suivi de booking', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'etapesuivibookingshow', 'afficher le détail d\'une etape de suivi de booking', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'etapesuivibookingupdate', 'modifier une etape de suivi de booking', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'etapesuivibookingdelete', 'supprimer une etape de suivi de booking', 'api', now(), now());

# LieuAppro
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('lieuapprofilter', 'filtrer la liste des lieux d\'approvisionnement', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'lieuappropaginate', 'paginer la liste des lieux d\'approvisionnement', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'lieuapproindex', 'afficher la liste des lieux d\'approvisionnement', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'lieuapprocreate', 'créer un lieu d\'approvisionnement', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'lieuapproshow', 'afficher le détail d\'un lieu d\'approvisionnement', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'lieuapproupdate', 'modifier un lieu d\'approvisionnement', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'lieuapprodelete', 'supprimer un lieu d\'approvisionnement', 'api', now(), now());

# StationEmpotage
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('stationempotagefilter', 'filtrer la liste des stations d\'empotage', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'stationempotagepaginate', 'paginer la liste des stations d\'empotage', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'stationempotageindex', 'afficher la liste des stations d\'empotage', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'stationempotagecreate', 'créer une station d\'empotage', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'stationempotageshow', 'afficher le détail d\'une station d\'empotage', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'stationempotageupdate', 'modifier une station d\'empotage', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'stationempotagedelete', 'supprimer une station d\'empotage', 'api', now(), now());

# Transporteur
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('transporteurfilter', 'filtrer la liste des transporteurs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'transporteurpaginate', 'paginer la liste des transporteurs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'transporteurindex', 'afficher la liste des transporteurs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'transporteurcreate', 'créer un transporteur', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'transporteurshow', 'afficher le détail d\'un transporteur', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'transporteurupdate', 'modifier un transporteur', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'transporteurdelete', 'supprimer un transporteur', 'api', now(), now());



# A_Etatcs
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('aetatcfilter', 'filtrer la liste des aetatcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'aetatcpaginate', 'paginer la liste des aetatcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'aetatcindex', 'afficher la liste des aetatcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'aetatccreate', 'créer un aetatc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'aetatcshow', 'afficher le détail d\'un aetatc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'aetatcupdate', 'modifier un aetatc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'aetatcdelete', 'supprimer un aetatc', 'api', now(), now());

# A_Tcsdeb
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('atcsdebfilter', 'filtrer la liste des atcsdebs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'atcsdebpaginate', 'paginer la liste des atcsdebs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'atcsdebindex', 'afficher la liste des atcsdebs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'atcsdebcreate', 'créer un atcsdeb', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'atcsdebshow', 'afficher le détail d\'un atcsdeb', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'atcsdebupdate', 'modifier un atcsdeb', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'atcsdebdelete', 'supprimer un atcsdeb', 'api', now(), now());

# A_Tcsemb
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('atcsembfilter', 'filtrer la liste des atcsembs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'atcsembpaginate', 'paginer la liste des atcsembs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'atcsembindex', 'afficher la liste des atcsembs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'atcsembcreate', 'créer un atcsemb', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'atcsembshow', 'afficher le détail d\'un atcsemb', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'atcsembupdate', 'modifier un atcsemb', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'atcsembdelete', 'supprimer un atcsemb', 'api', now(), now());

# Client
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('clientfilter', 'filtrer la liste des clients', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'clientpaginate', 'paginer la liste des clients', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'clientindex', 'afficher la liste des clients', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'clientcreate', 'créer un client', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'clientshow', 'afficher le détail d\'un client', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'clientupdate', 'modifier un client', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'clientdelete', 'supprimer un client', 'api', now(), now());

# Escale
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('escalefilter', 'filtrer la liste des escales', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'escalepaginate', 'paginer la liste des escales', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'escaleindex', 'afficher la liste des escales', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'escalecreate', 'créer une escale', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'escaleshow', 'afficher le détail d\'une escale', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'escaleupdate', 'modifier une escale', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'escaledelete', 'supprimer une escale', 'api', now(), now());

# Navire
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('navirefilter', 'filtrer la liste des navires', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'navirepaginate', 'paginer la liste des navires', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'navireindex', 'afficher la liste des navires', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'navirecreate', 'créer un navire', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'navireshow', 'afficher le détail d\'un navire', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'navireupdate', 'modifier un navire', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'naviredelete', 'supprimer un navire', 'api', now(), now());

# Operateu
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('operateufilter', 'filtrer la liste des operateurs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'operateupaginate', 'paginer la liste des operateurs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'operateuindex', 'afficher la liste des operateurs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'operateucreate', 'créer un operateur', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'operateushow', 'afficher le détail d\'un operateur', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'operateuupdate', 'modifier un operateur', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'operateudelete', 'supprimer un operateur', 'api', now(), now());

# Port
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('portfilter', 'filtrer la liste des ports', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'portpaginate', 'paginer la liste des ports', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'portindex', 'afficher la liste des ports', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'portcreate', 'créer un port', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'portshow', 'afficher le détail d\'un port', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'portupdate', 'modifier un port', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'portdelete', 'supprimer un port', 'api', now(), now());

# Produit
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('produitfilter', 'filtrer la liste des produits', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'produitpaginate', 'paginer la liste des produits', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'produitindex', 'afficher la liste des produits', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'produitcreate', 'créer un produit', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'produitshow', 'afficher le détail d\'un produit', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'produitupdate', 'modifier un produit', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'produitdelete', 'supprimer un produit', 'api', now(), now());

# Situation_Tc
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('situationtcfilter', 'filtrer la liste des situationtcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'situationtcpaginate', 'paginer la liste des situationtcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'situationtcindex', 'afficher la liste des situationtcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'situationtccreate', 'créer une situationtc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'situationtcshow', 'afficher le détail d\'une situationtc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'situationtcupdate', 'modifier une situationtc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'situationtcdelete', 'supprimer une situationtc', 'api', now(), now());

# TcsBase
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('tcsbasefilter', 'filtrer la liste des tcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'tcsbasepaginate', 'paginer la liste des tcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'tcsbaseindex', 'afficher la liste des tcs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'tcsbasecreate', 'créer un tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'tcsbaseshow', 'afficher le détail d\'un tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'tcsbaseupdate', 'modifier un tc', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'tcsbasedelete', 'supprimer un tc', 'api', now(), now());

# Username
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('usernamefilter', 'filtrer la liste des comptes utilisateurs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'usernamepaginate', 'paginer la liste des comptes utilisateurs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'usernameindex', 'afficher la liste des comptes utilisateurs', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'usernamecreate', 'créer un compte utilisateur', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'usernameshow', 'afficher le détail d\'un compte utilisateur', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'usernameupdate', 'modifier un compte utilisateur', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'usernamedelete', 'supprimer un compte utilisateur', 'api', now(), now());



# Engin
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('enginfilter', 'filtrer la liste des engins', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'enginpaginate', 'paginer la liste des engins', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'enginindex', 'afficher la liste des engins', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'engincreate', 'créer un engin', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'enginshow', 'afficher le détail d\'un engin', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'enginupdate', 'modifier un engin', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'engindelete', 'supprimer un engin', 'api', now(), now());

# LigneSortie
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('lignesortiefilter', 'filtrer la liste des lignesorties', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'lignesortiepaginate', 'paginer la liste des lignesorties', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'lignesortieindex', 'afficher la liste des lignesorties', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'lignesortiecreate', 'créer une lignesortie', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'lignesortieshow', 'afficher le détail d\'une lignesortie', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'lignesortieupdate', 'modifier une lignesortie', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'lignesortiedelete', 'supprimer une lignesortie', 'api', now(), now());

# OT
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('otfilter', 'filtrer la liste des ots', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'otpaginate', 'paginer la liste des ots', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'otindex', 'afficher la liste des ots', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'otcreate', 'créer un ot', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'otshow', 'afficher le détail d\'un ot', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'otupdate', 'modifier un ot', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'otdelete', 'supprimer un ot', 'api', now(), now());

# Piece
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('piecefilter', 'filtrer la liste des pièces', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'piecepaginate', 'paginer la liste des pièces', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'pieceindex', 'afficher la liste des pièces', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'piececreate', 'créer une pièce', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'pieceshow', 'afficher le détail d\'une pièce', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'pieceupdate', 'modifier une pièce', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'piecedelete', 'supprimer une pièce', 'api', now(), now());

# Sortie
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('sortiefilter', 'filtrer la liste des sorties', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'sortiepaginate', 'paginer la liste des sorties', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'sortieindex', 'afficher la liste des sorties', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'sortiecreate', 'créer une sortie', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'sortieshow', 'afficher le détail d\'une sortie', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'sortieupdate', 'modifier une sortie', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'sortiedelete', 'supprimer une sortie', 'api', now(), now());



# Carburant
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('carburantfilter', 'filtrer la liste des prises de carburant', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'carburantpaginate', 'paginer la liste des prises de carburant', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'carburantindex', 'afficher la liste des prises de carburant', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'carburantcreate', 'créer une prise de carburant', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'carburantshow', 'afficher le détail d\'une prise de carburant', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'carburantupdate', 'modifier une prise de carburant', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'carburantdelete', 'supprimer une prise de carburant', 'api', now(), now());

# Export
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('exportfilter', 'filtrer la liste des exports', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'exportpaginate', 'paginer la liste des exports', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'exportindex', 'afficher la liste des exports', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'exportcreate', 'créer une export', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'exportshow', 'afficher le détail d\'une export', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'exportupdate', 'modifier une export', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'exportdelete', 'supprimer une export', 'api', now(), now());



# Permission
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('permissionfilter', 'filtrer la liste des permissions', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'permissionpaginate', 'paginer la liste des permissions', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'permissionindex', 'afficher la liste des permissions', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'permissioncreate', 'créer une permission', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'permissionshow', 'afficher le détail d\'une permission', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'permissionupdate', 'modifier une permission', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'permissiondelete', 'supprimer une permission', 'api', now(), now());

# Role
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('rolefilter', 'filtrer la liste des rôles', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'rolepaginate', 'paginer la liste des rôles', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'roleindex', 'afficher la liste des rôles', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'rolecreate', 'créer un rôle', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'roleshow', 'afficher le détail d\'un rôle', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'roleupdate', 'modifier un rôle', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'roledelete', 'supprimer un rôle', 'api', now(), now());

# User
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('userfilter', 'filtrer la liste des users', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'userpaginate', 'paginer la liste des users', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'userindex', 'afficher la liste des users', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'usercreate', 'créer un user', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'usershow', 'afficher le détail d\'un user', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'userupdate', 'modifier un user', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'userdelete', 'supprimer un user', 'api', now(), now());

# Panne
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('pannefilter', 'filtrer la liste des pannes', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'pannepaginate', 'paginer la liste des pannes', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'panneindex', 'afficher la liste des pannes', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'pannecreate', 'créer une panne', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'panneshow', 'afficher le détail d\'une panne', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'panneupdate', 'modifier une panne', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'pannedelete', 'supprimer une panne', 'api', now(), now());

# Typengin
INSERT INTO `permissions` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('typenginfilter', 'filtrer la liste des types d\'engins', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'typenginpaginate', 'paginer la liste des types d\'engins', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'typenginindex', 'afficher la liste des types d\'engins', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'typengincreate', 'créer un type d\'engin', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'typenginshow', 'afficher le détail d\'un type d\'engin', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'typenginupdate', 'modifier un type d\'engin', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'typengindelete', 'supprimer un type d\'engin', 'api', now(), now());



