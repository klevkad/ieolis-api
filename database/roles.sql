
# Roles
INSERT INTO `roles` (`name`, `libelle`, `guard_name`, `created_at`, `updated_at`) VALUES
('admin', 'Administrateur', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'direction', 'Membre de l\'équipe de direction', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'ops-client', 'Agent du client', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'ops-commercial', 'Agent du commercial', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'ops-comptabilite', 'Agent de la comptabilité', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'ops-shipping', 'Agent du shipping', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'ops-facturation', 'Agent de la facturation', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'ops-informatique', 'Agent de l\'informatique', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'ops-transit', 'Agent du transit', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'ops-manutention', 'Agent de la manutention', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'ops-acconage', 'Agent de l\'acconage', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'ops-transport', 'Agent du transport', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'ops-technique', 'Agent du garage', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'ops-infirmerie', 'Agent de l\'infirmerie', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'resp-client', 'Responsable du client', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'resp-commercial', 'Responsable du commercial', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'resp-comptabilite', 'Responsable de la comptabilité', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'resp-shipping', 'Responsable du shipping', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'resp-facturation', 'Responsable de la facturation', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'resp-informatique', 'Responsable de l\'informatique', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'resp-transit', 'Responsable du transit', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'resp-manutention', 'Responsable de la manutention', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'resp-acconage', 'Responsable de l\'acconage', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'resp-transport', 'Responsable du transport', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'resp-technique', 'Responsable du technique', 'api', now(), now())
	INTO `permissions` (`id`, `name`, `guard_name`, `libelle`, `created_at`, `updated_at`) VALUES 'resp-infirmerie', 'Responsable de l\'infirmerie', 'api', now(), now());


# Role Admin Has Permissions
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) 
SELECT `permissions`.`id`, `roles`.`id`
FROM `permissions`, `roles`
WHERE `roles`.`name` = 'admin';

# Role Candidat Has Permissions
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) 
SELECT `permissions`.`id`, `roles`.`id`
FROM `permissions`, `roles`
WHERE `permissions`.`name` IN (
    'menudashboard', 'menusynthese',
    'adversairefilter', 'adversairepaginate', 'adversaireindex', 'adversairecreate', 'adversaireshow', 'adversaireupdate', 'adversairedelete',
    'bureaufilter', 'bureaupaginate', 'bureauindex', 'bureaucreate', 'bureaushow', 'bureauupdate', 'bureaudelete',
    'campagneshow',
    'candidatshow', 'candidatupdate',
    'centrefilter', 'centrepaginate', 'centreindex', 'centrecreate', 'centreshow', 'centreupdate', 'centredelete',
    'communefilter', 'communeshow',
    'localitefilter', 'localiteshow',
    'partifilter', 'partishow',
    'paysfilter', 'paysshow',
    'regionfilter', 'regionshow',
    'representantbureauindex', 'representantbureaucreate', 'representantbureaushow', 'representantbureauupdate', 'representantbureaudelete',
    'representantcentreindex', 'representantcentrecreate', 'representantcentreshow', 'representantcentreupdate', 'representantcentredelete'
    'typecampagneshow',
    'userfilter', 'userpaginate', 'userindex', 'usercreate', 'usershow', 'userupdate', 'userdelete',
    'villefilter', 'villeshow'
) AND `roles`.`name` = 'candidat';

# Role RepresentantBureau Has Permissions
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) 
SELECT `permissions`.`id`, `roles`.`id`
FROM `permissions`, `roles`
WHERE `permissions`.`name` IN (
    'menudashboard', 'menusynthese',
    'adversaireshow',
    'bureaushow', 'bureauupdate',
    'campagneshow',
    'candidatshow',
    'centreshow',
    'communeshow',
    'localiteshow',
    'partishow',
    'paysshow',
    'regionshow',
    'representantbureaushow', 'representantbureauupdate',
    'representantcentreshow',
    'typecampagneshow',
    'usershow', 'userupdate',
    'villeshow'
) AND `roles`.`name` = 'representantbureau';

# Role RepresentantCentre Has Permissions
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) 
SELECT `permissions`.`id`, `roles`.`id`
FROM `permissions`, `roles`
WHERE `permissions`.`name` IN (
    'menudashboard', 'menusynthese',
    'adversaireshow',
    'bureaufilter', 'bureaupaginate', 'bureauindex', 'bureaucreate', 'bureaushow', 'bureauupdate', 'bureaudelete',
    'campagneshow',
    'candidatshow',
    'centreshow', 'centreupdate',
    'communeshow',
    'localiteshow',
    'partishow',
    'paysshow',
    'regionshow',
    'representantbureauindex', 'representantbureaucreate', 'representantbureaushow', 'representantbureauupdate', 'representantbureaudelete',
    'representantcentreshow', 'representantcentreupdate',
    'typecampagneshow',
    'usershow', 'userupdate',
    'villeshow'    
) AND `roles`.`name` = 'representantcentre';
