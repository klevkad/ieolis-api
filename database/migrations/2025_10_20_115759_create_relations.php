<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Employe se trouve dans le schema EOLIS
        Schema::connection('parc')->create('reptc_employe', function (Blueprint $table) {
            $table->foreignId('reptc_id')->references('id')->on('reptcs')->onDelete('restrict');
            $table->string('reptc_agent_code',20)
                  ->foreign('reptc_agent_code')
                  ->references('code_emp')
                  ->on('employe')
                  ->onDelete('restrict');
            $table->primary(['reptc_id','reptc_agent_code']);
        });

        Schema::connection('parc')->create('reptc_piece', function (Blueprint $table) {
            $table->foreignId('reptc_id')->references('id')->on('reptcs')->onDelete('restrict');
            $table->unsignedInteger('idpiece')->foreign('idpiece')->references('idpiece')->on('piece')->onDelete('restrict');
            $table->unsignedInteger('codeunite')->foreign('codeunite')->references('codeunite')->on('unite')->onDelete('restrict');
            $table->unsignedFloat('pu')->nullable();
            $table->unsignedFloat('qte')->nullable();
            $table->primary(['reptc_id','idpiece']);
        });

        Schema::connection('parc')->create('reptc_reptc_side', function (Blueprint $table) {
            $table->foreignId('reptc_id')->references('id')->on('reptcs')->onDelete('restrict');
            $table->string('reptc_side_id',12)->foreign('reptc_side_id')->references('id')->on('reptc_side')->onDelete('restrict');
            $table->string('reptc_action_id',12)->foreign('reptc_action_id')->references('id')->on('reptc_actions')->onDelete('restrict');
            $table->string('constat')->nullable();
            $table->primary(['reptc_id','reptc_side_id','reptc_action_id']);
        });

        Schema::connection('parc')->create('batterie_prise', function (Blueprint $table) {
            $table->foreignId('batterie_id')->references('id')->on('batteries')->onDelete('restrict');
            $table->foreignId('prise_id')->references('id')->on('prises')->onDelete('restrict');
            $table->date('debut')->nullable();
            $table->date('fin')->nullable();
            $table->string('observation')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->primary(['batterie_id','prise_id', 'debut']);
        });

        Schema::connection('parc')->create('batterie_engin', function (Blueprint $table) {
            $table->foreignId('batterie_id')->references('id')->on('batteries')->onDelete('restrict');
            $table->string('idengin',7)->foreign('idengin')->references('id')->on('engin')->onDelete('restrict');
            $table->date('debut')->nullable();
            $table->date('fin')->nullable();
            $table->string('observation')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->primary(['batterie_id','idengin', 'debut']);
        });

        Schema::connection('parc')->create('batterie_working_time', function (Blueprint $table) {
            $table->foreignId('signal_panne_id')->references('signal_panne_id')->on('batterie_engin')->onDelete('restrict');
            $table->date('debut')->nullable();
            $table->date('fin')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->primary(['signal_panne_id', 'debut']);
        });

        Schema::connection('parc')->create('batterie_chargeur', function (Blueprint $table) {
            $table->foreignId('batterie_id')->references('id')->on('batteries')->onDelete('restrict');
            $table->foreignId('chargeur_id')->references('id')->on('chargeurs')->onDelete('restrict');
            $table->date('debut')->nullable();
            $table->date('fin')->nullable();
            $table->string('observation')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->primary(['batterie_id','prise_id', 'debut']);
        });

        Schema::connection('parc')->create('batterie_reception', function (Blueprint $table) {
            $table->foreignId('batterie_id')->references('id')->on('batteries')->onDelete('restrict');
            $table->foreignId('mod_docker_matricule')->references('matricule')->on('mod_dockers')->onDelete('restrict');
            $table->date('date_reception')->nullable();
            $table->string('observation')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->primary(['batterie_id','prise_id', 'debut']);
        });



        Schema::create('a_etape_booking', function (Blueprint $table) {
            $table->string('codeetape_suivi_booking',20)
                ->foreign('codeetape_suivi_booking')
                ->references('codeetape_suivi_booking')
                ->on('etape_suivi_booking')
                ->onDelete('restrict');
            $table->unsignedBigInteger('iddemande_booking')
                ->foreign('iddemande_booking')
                ->references('iddemande_booking')
                ->on('p_demande_booking')
                ->onDelete('restrict');
            $table->dateTime('dateetape');
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
        });


        Schema::table('chauffeur', function (Blueprint $table) {
            $table->foreign('idtransporteur')
                ->references('idtransporteur')
                ->on('transporteur')
                ->onDelete('restrict');
        });

/*
        Schema::table('lieu_appro', function (Blueprint $table) {
            $table->foreign('idlieu')
                ->references('codeport')
                ->on('port')
                ->onDelete('restrict');
        });
*/

/*
        Schema::table('station_empotage', function (Blueprint $table) {
            $table->foreign('idlieu')
                ->references('codeport')
                ->on('port')
                ->onDelete('restrict');
        });
*/

        Schema::table('attribution_clipon', function (Blueprint $table) {
            $table->foreign('idattribution_tc')
                ->references('idattribution_tc')
                ->on('attribution_tc')
                ->onDelete('restrict');
/*
            $table->foreign('idclipon')
                ->references('idengin')
                ->on('engin')
                ->onDelete('restrict');
*/
            $table->foreign('idlieu_appro')
                ->references('idlieu_appro')
                ->on('lieu_appro')
                ->onDelete('restrict');
        });

        Schema::table('attribution_clipon_verif', function (Blueprint $table) {
            $table->foreign('idattribution_tc')
                ->references('idattribution_tc')
                ->on('attribution_clipon')
                ->onDelete('restrict');
        });

        Schema::table('attribution_clipon_retour', function (Blueprint $table) {
            $table->foreign('idretour_conteneur')
                ->references('idretour_conteneur')
                ->on('retour_conteneur')
                ->onDelete('restrict');
/*
            $table->foreign('idclipon')
                ->references('idengin')
                ->on('engin')
                ->onDelete('restrict');
*/
            $table->foreign('idlieu_appro_clip')
                ->references('idlieu_appro')
                ->on('lieu_appro')
                ->onDelete('restrict');
        });

        Schema::table('attribution_clipon_ret_verif', function (Blueprint $table) {
            $table->foreign('idretour_conteneur')
                ->references('idretour_conteneur')
                ->on('attribution_clipon_retour')
                ->onDelete('restrict');
        });

        Schema::table('attribution_tc', function (Blueprint $table) {
            $table->foreign('idbooking_conteneur')
                ->references('idbooking_conteneur')
                ->on('booking_conteneur')
                ->onDelete('restrict');
        });

        Schema::table('booking_conteneur', function (Blueprint $table) {
            $table->foreign('iddemande_booking')
                ->references('iddemande_booking')
                ->on('p_demande_booking')
                ->onDelete('restrict');

            //$table->foreign('codetype_tc',5);
        });

        Schema::table('booking_final_tc', function (Blueprint $table) {
            $table->foreign('iddemande_booking')
                ->references('iddemande_booking')
                ->on('booking_conteneur')
                ->onDelete('restrict');
        });

        Schema::table('p_demande_booking', function (Blueprint $table) {

/*
            $table->foreign('idlieu_arrive')
                ->references('codeport')
                ->on('port')
                ->onDelete('restrict');
*/

            $table->foreign('idutilisateur_client')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            $table->foreign('idtransporteur')
                ->references('idtransporteur')
                ->on('transporteur')
                ->onDelete('restrict');

/*
            $table->foreign('ct_num')
                ->references('codeport')
                ->on('port')
                ->onDelete('restrict');
*/
/*
            $table->foreign('noescale')
                ->references('noescale')
                ->on('escale')
                ->onDelete('restrict');
*/
/*
            $table->foreign('payeurfret')
                ->references('codeport')
                ->on('port')
                ->onDelete('restrict');
*/
/*
            $table->foreign('produit')
                ->references('produit')
                ->on('produit')
                ->onDelete('restrict');
*/
        });

        Schema::table('emb_conteneur', function (Blueprint $table) {
            $table->foreign('idretour_conteneur')
                ->references('idretour_conteneur')
                ->on('fin_retour_tc')
                ->onDelete('restrict');
/*
            $table->foreign('noescale')
                ->references('noescale')
                ->on('escale')
                ->onDelete('restrict');
*/
        });

        Schema::table('empotage_tc_posit', function (Blueprint $table) {
            $table->foreign('idpositionnement')
                ->references('idpositionnement')
                ->on('fin_posit_tc')
                ->onDelete('restrict');

            $table->foreign('codestation_empotage')
                ->references('codestation_empotage')
                ->on('station_empotage')
                ->onDelete('restrict');
        });

        Schema::table('fin_posit_tc', function (Blueprint $table) {
            $table->foreign('idpositionnement')
                ->references('idpositionnement')
                ->on('positionnement_tc')
                ->onDelete('restrict');
        });

        Schema::table('fin_posit_clipon_verif', function (Blueprint $table) {
            $table->foreign('idpositionnement')
                ->references('idpositionnement')
                ->on('fin_posit_tc')
                ->onDelete('restrict');
        });

        Schema::table('fin_retour_tc', function (Blueprint $table) {
            $table->foreign('idretour_conteneur')
                ->references('idretour_conteneur')
                ->on('retour_conteneur')
                ->onDelete('restrict');

			$table->foreign('idlieu_appro_cli_arr')
                ->references('idlieu_appro')
                ->on('lieu_appro')
                ->onDelete('restrict');

			$table->foreign('idlieu_appro_cam')
                ->references('idlieu_appro')
                ->on('lieu_appro')
                ->onDelete('restrict');
        });

        Schema::table('fin_retour_clipon_verif', function (Blueprint $table) {
            $table->foreign('idretour_conteneur')
                ->references('idretour_conteneur')
                ->on('fin_retour_tc')
                ->onDelete('restrict');
        });

        Schema::table('motif_refus_booking', function (Blueprint $table) {
            $table->foreign('iddemande_booking')
                ->references('iddemande_booking')
                ->on('p_demande_booking')
                ->onDelete('restrict');
        });

        Schema::table('param_tc_reefer', function (Blueprint $table) {
            $table->foreign('idbooking_conteneur')
                ->references('idbooking_conteneur')
                ->on('booking_conteneur')
                ->onDelete('restrict');
        });

        Schema::table('positionnement_tc', function (Blueprint $table) {
/*
            $table->foreign('idremorque')
                ->references('idengin')
                ->on('engin')
                ->onDelete('restrict');

            $table->foreign('idcamion')
                ->references('idengin')
                ->on('engin')
                ->onDelete('restrict');
*/
            $table->foreign('idchauffeur')
                ->references('idchauffeur')
                ->on('chauffeur')
                ->onDelete('restrict');

            $table->foreign('idtransporteur')
                ->references('idtransporteur')
                ->on('transporteur')
                ->onDelete('restrict');

            $table->foreign('idactivites')
                ->references('idactivites')
                ->on('activites')
                ->onDelete('restrict');

/*
            $table->foreign('idlieu_depart')
                ->references('codeport')
                ->on('port')
                ->onDelete('restrict');
*/
/*
            $table->foreign('idlieu_arrive')
                ->references('codeport')
                ->on('port')
                ->onDelete('restrict');
*/

            $table->foreign('idlieu_appro')
                ->references('idlieu_appro')
                ->on('lieu_appro')
                ->onDelete('restrict');

            $table->foreign('idattribution_tc')
                ->references('idattribution_tc')
                ->on('attribution_tc')
                ->onDelete('restrict');
        });

        Schema::table('posit_propre_moy', function (Blueprint $table) {
            $table->foreign('idattribution_tc')
                ->references('idattribution_tc')
                ->on('attribution_tc')
                ->onDelete('restrict');
        });

        Schema::table('retour_conteneur', function (Blueprint $table) {
            $table->foreign('idretour_conteneur')
                ->references('idretour_tc')
                ->on('retour_tc_main')
                ->onDelete('restrict');
/*
            $table->foreign('idremorque')
                ->references('idengin')
                ->on('engin')
                ->onDelete('restrict');

            $table->foreign('idcamion')
                ->references('idengin')
                ->on('engin')
                ->onDelete('restrict');
*/
            $table->foreign('idchauffeur')
                ->references('idchauffeur')
                ->on('chauffeur')
                ->onDelete('restrict');

            $table->foreign('idtransporteur')
                ->references('idtransporteur')
                ->on('transporteur')
                ->onDelete('restrict');

            $table->foreign('idpositionnement')
                ->references('idpositionnement')
                ->on('positionnement_tc')
                ->onDelete('restrict');
        });

        Schema::table('retour_tc_propre_moy', function (Blueprint $table) {
            $table->foreign('idretour_tc')
                ->references('idretour_tc')
                ->on('retour_tc_main')
                ->onDelete('restrict');

            $table->foreign('idattribution_tc')
                ->nullable()
                ->references('idattribution_tc')
                ->on('posit_propre_moy')
                ->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relations');
    }
}
