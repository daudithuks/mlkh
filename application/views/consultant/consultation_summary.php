<table>
<tr><td><b>Patient Name:&emsp;</b></td><td><?php echo ucwords($customer); ?></td></tr>
<tr><td><b>Diagnosed by:&emsp;</b></td><td>Dr. <?php echo ucwords($consultant); ?></td></tr>
<tr><td><b>Date:&emsp;</b></td><td><?php echo !empty($date)?$date:date('m/d/Y h:i:s a'); ?></td></tr>
</table>
<hr />
<?php if(!empty($complaints)){ ?>
<div id="examination_header_bar">Chief Complaints</div>
<table><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody valign="top">
<?php if(!empty($complaints['cns'])){ ?>
<tr><th>CNS:&emsp;</th><td><?php echo str_replace("\n", "<br />", $complaints['cns']); ?></td></tr>
<?php } ?>
<tr><td>&nbsp;</td></tr>
<?php if(!empty($complaints['ris'])){ ?>
<tr><th>RIS:&emsp;</th><td><?php echo str_replace("\n", "<br />", $complaints['ris']); ?></td></tr>
<?php } ?>
<tr><td>&nbsp;</td></tr>
<?php if(!empty($complaints['cvs'])){ ?>
<tr><th>CVS:&emsp;</th><td><?php echo str_replace("\n", "<br />", $complaints['cvs']); ?></td></tr>
<?php } ?>
<tr><td>&nbsp;</td></tr>
<?php if(!empty($complaints['git'])){ ?>
<tr><th>GIT:&emsp;</th><td><?php echo str_replace("\n", "<br />", $complaints['git']); ?></td></tr>
<?php } ?>
<tr><td>&nbsp;</td></tr>
<?php if(!empty($complaints['mis'])){ ?>
<tr><th>MIS:&emsp;</th><td><?php echo str_replace("\n", "<br />", $complaints['mis']); ?></td></tr>
<?php } ?>
<tr><td>&nbsp;</td></tr>
<?php if(!empty($complaints['dental'])){ ?>
<tr><th>Dental:&emsp;</th><td><?php echo str_replace("\n", "<br />", $complaints['dental']); ?></td></tr>
<?php } ?>
<tr><td>&nbsp;</td></tr>
<?php if(!empty($complaints['eye'])){ ?>
<tr><th>Eye:&emsp;</th><td><?php echo str_replace("\n", "<br />", $complaints['eye']); ?></td></tr>
<?php } ?>
<tr><td>&nbsp;</td></tr>
<?php if(!empty($complaints['ent'])){ ?>
<tr><th>ENT:&emsp;</th><td><?php echo str_replace("\n", "<br />", $complaints['ent']); ?></td></tr>
<?php } ?>
<tr><td>&nbsp;</td></tr>
<?php if(!empty($complaints['genitalia'])){ ?>
<tr><th>Genitalia:&emsp;</th><td><?php echo str_replace("\n", "<br />", $complaints['genitalia']); ?></td></tr>
<?php } ?>
<tr><td>&nbsp;</td></tr>
<?php if(!empty($complaints['obstetrics and gynaecology']) && $gender=='female'){ ?>
<tr><th>Obstetrics and Gynaecology:&emsp;</th><td><?php echo str_replace("\n", "<br />", $complaints['obstetrics and gynaecology']); ?></td></tr>
<?php } ?>
</tbody></table>
<hr />
<?php } ?>

<?php if(!empty($medical_history)){ ?>
<div id="examination_header_bar">Medical History</div>
<table><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody valign="top">
<?php if(!empty($medical_history['previous_admission'])){ ?>
<tr><th>Previous Admissions:&emsp;</th><td><?php echo str_replace("\n", "<br />", $medical_history['previous_admission']); ?></td></tr>
<?php } ?>
<?php if(!empty($medical_history['medication'])){ ?>
<tr><th>Medication:&emsp;</th><td><?php echo str_replace("\n", "<br />", $medical_history['medication']); ?></td></tr>
<?php } ?>
<?php if(!empty($medical_history['allergies'])){ ?>
<tr><th>Allergies:&emsp;</th><td><?php echo str_replace("\n", "<br />", $medical_history['allergies']); ?></td></tr>
<?php } ?>
<?php if(!empty($medical_history["chronic_illness"])){ ?>
<tr><th>Chronic Illness:&emsp;</th><td><?php echo str_replace("\n", "<br />", $medical_history["chronic_illness"]); ?></td></tr>
<?php } ?>
<?php if(!empty($medical_history["previous_surgery"])){ ?>
<tr><th>Previous Surgery:&emsp;</th><td><?php echo str_replace("\n", "<br />", $medical_history["previous_surgery"]); ?></td></tr>
<?php } ?>
</tbody></table>
<hr />
<?php } ?>

<?php if(!empty($family_history)){ ?>
<div id="examination_header_bar">Family/Social History</div>
<table><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody valign="top">
<?php if(!empty($family_history['occupation'])){ ?>
<tr><th>Occupation:&emsp;</th><td><?php echo str_replace("\n", "<br />", $family_history['occupation']); ?></td></tr>
<?php } ?>
<?php if(!empty($family_history['alcohol'])){ ?>
<tr><th>Alcohol:&emsp;</th><td><?php echo str_replace("\n", "<br />", $family_history['alcohol']); ?></td></tr>
<?php } ?>
<?php if(!empty($family_history['cigarettes'])){ ?>
<tr><th>Cigarettes:&emsp;</th><td><?php echo str_replace("\n", "<br />", $family_history['cigarettes']); ?></td></tr>
<?php } ?>
<?php if(!empty($family_history["familial_diseases"])){ ?>
<tr><th>Familial Diseases:&emsp;</th><td><?php echo str_replace("\n", "<br />", $family_history["familial_diseases"]); ?></td></tr>
<?php } ?>
</tbody></table>
<hr />
<?php } ?>

<?php if(!empty($obst_gyn) && $gender == 'female'){ ?>
<div id="examination_header_bar">Obstetrics and Gynaecology History</div>
<table><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody valign="top">
<?php if(!empty($obst_gyn['parity'])){ ?>
<tr><th>Parity:&emsp;</th><td><?php echo str_replace("\n", "<br />", $obst_gyn['parity']); ?></td></tr>
<?php } ?>
<?php if(!empty($obst_gyn['gravida'])){ ?>
<tr><th>Gravida:&emsp;</th><td><?php echo str_replace("\n", "<br />", $obst_gyn['gravida']); ?></td></tr>
<?php } ?>
<?php if(!empty($obst_gyn['lmp_start'])){ ?>
<tr><th>LMP:&emsp;</th><td><?php echo str_replace("\n", "<br />", $obst_gyn['lmp_start'])." to ".str_replace("\n", "<br />", $obst_gyn['lmp_end']); ?></td></tr>
<?php } ?>
<?php if(!empty($obst_gyn["menarche"])){ ?>
<tr><th>Menarche:&emsp;</th><td><?php echo str_replace("\n", "<br />", $obst_gyn["menarche"]); ?></td></tr>
<?php } ?>
<?php if(!empty($obst_gyn["menses"])){ ?>
<tr><th>Menses:&emsp;</th><td><?php echo str_replace("\n", "<br />", $obst_gyn["menses"]); ?></td></tr>
<?php } ?>
</tbody></table>
<hr />
<?php } ?>

<?php if(!empty($examination)){ ?>
<div id="examination_header_bar">General Examination</div>
<table><thead valign="top">
<?php if(!empty($examination['general_condition'])){ ?>
<tr><th>Condition:&emsp;</th><td><?php echo str_replace("\n", "<br />", $examination['general_condition']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['general_pallor'])){ ?>
<tr><th>Pallor:&emsp;</th><td><?php echo str_replace("\n", "<br />", $examination['general_pallor']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['general_jaundice'])){ ?>
<tr><th>Jaundice:&emsp;</th><td><?php echo str_replace("\n", "<br />", $examination['general_jaundice']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['general_oedema'])){ ?>
<tr><th>Oedema:&emsp;</th><td><?php echo str_replace("\n", "<br />", $examination['general_oedema']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['general_lymphadenopathy'])){ ?>
<tr><th>Lymphadenopathy:&emsp;</th><td><?php echo str_replace("\n", "<br />", $examination['general_lymphadenopathy']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['general_cyanosis'])){ ?>
<tr><th>Cyanosis:&emsp;</th><td><?php echo str_replace("\n", "<br />", $examination['general_cyanosis']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['general_oral_thrush'])){ ?>
<tr><th>Oral Thrush:&emsp;</th><td><?php echo str_replace("\n", "<br />", $examination['general_oral_thrush']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['general_finger_clubbing'])){ ?>
<tr><th>Finger Clubbing:&emsp;</th><td><?php echo str_replace("\n", "<br />", $examination['general_finger_clubbing']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['general_examination_remarks'])){ ?>
<tr><th>Other Remarks:&emsp;</th><td><?php echo str_replace("\n", "<br />", $examination['general_examination_remarks']); ?></td></tr>
<?php } ?>
</thead><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody><tr><td></td></tr></tbody></table>

<div id="examination_header_bar">Systemic Examinations</div>

<?php //if(!empty($examination['cns'])){ ?>
<table><thead><tr><th>CNS</th></tr></thead><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody valign="top">
<?php if(!empty($examination['cns_gcs'])){ ?>
<tr><td style="font-style:italic;">GCS:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['cns_gcs']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['cns_neck_soft'])){ ?>
<tr><td style="font-style:italic;">Neck Soft:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['cns_neck_soft']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['cns_pupils'])){ ?>
<tr><td style="font-style:italic;">Pupils:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['cns_pupils']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['cns_cranial_nerves'])){ ?>
<tr><td style="font-style:italic;">Cranial Nerves:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['cns_cranial_nerves']);
if (!empty($examination['cns_cranial_nerves_describe'])) echo " (".str_replace("\n", "<br />", $examination['cns_cranial_nerves_describe']).") "; ?></td></tr>
<?php } ?>
<?php if(!empty($examination['cns_sensory_motor'])){ ?>
<tr><td style="font-style:italic;">Sensory Motor:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['cns_sensory_motor']);
if (!empty($examination['cns_sensory_motor_describe'])) echo " (".str_replace("\n", "<br />", $examination['cns_sensory_motor_describe']).") "; ?></td></tr>
<?php } ?>
<?php if(!empty($examination['cns_examination_remarks'])){ ?>
<tr><td style="font-style:italic;">Other Remarks:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['cns_examination_remarks']); ?></td></tr>
<?php } ?>
</tbody></table>
<?php //} ?>

<?php //if(!empty($examination['ris'])){ ?>
<table><thead><tr><th>RIS</th></tr></thead><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody valign="top">
<?php if(!empty($examination['ris_moving_with_respiration'])){ ?>
<tr><td style="font-style:italic;">Moving with Respiration:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['ris_moving_with_respiration']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['ris_scars'])){ ?>
<tr><td style="font-style:italic;">Scars:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['ris_scars']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['ris_bilateral_expansion'])){ ?>
<tr><td style="font-style:italic;">Bilateral Expansion:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['ris_bilateral_expansion']); 
if (!empty($examination['ris_bilateral_expansion_describe'])) echo " (".str_replace("\n", "<br />", $examination['ris_bilateral_expansion_describe']).") "; ?></td></tr>
<?php } ?>
<?php if(!empty($examination['ris_percussion'])){ ?>
<tr><td style="font-style:italic;">Percussion:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['ris_percussion']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['ris_ausculation'])){ ?>
<tr><td style="font-style:italic;">Ausculation:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['ris_ausculation']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['ris_examination_remarks'])){ ?>
<tr><td style="font-style:italic;">Other Remarks:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['ris_examination_remarks']); ?></td></tr>
<?php } ?>
</tbody></table>
<?php //} ?>

<?php //if(!empty($examination['cvs'])){ ?>
<table><thead><tr><th>CVS</th></tr></thead><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody valign="top">
<?php if(!empty($examination['cvs_pulses_presence']) || !empty($examination['cvs_pulses_regularity'])){ ?>
<tr><td style="font-style:italic;">Pulses:&emsp;</td><td><?php if (!empty($examination['cvs_pulses_presence'])) echo str_replace("\n", "<br />", $examination['cvs_pulses_presence'])."; ";
if (!empty($examination['cvs_pulses_regularity'])) echo str_replace("\n", "<br />", $examination['cvs_pulses_regularity'])."; "; ?></td></tr>
<?php } ?>
<?php if(!empty($examination['cvs_volume'])){ ?>
<tr><td style="font-style:italic;">Volume:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['cvs_volume']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['cvs_peripheries'])){ ?>
<tr><td style="font-style:italic;">Peripheries:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['cvs_peripheries']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['cvs_jvp'])){ ?>
<tr><td style="font-style:italic;">JvP:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['cvs_jvp']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['cvs_precordium'])){ ?>
<tr><td style="font-style:italic;">Precordium:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['cvs_precordium']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['cvs_apex'])){ ?>
<tr><td style="font-style:italic;">Apex:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['cvs_apex']); 
if (isset($examination['cvs_apex_describe'])) echo " (".str_replace("\n", "<br />", $examination['cvs_apex_describe']).") "; ?></td></tr>
<?php } ?>
<?php if(!empty($examination['cvs_heart_sounds'])){ ?>
<tr><td style="font-style:italic;">Heart Sounds:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['cvs_heart_sounds']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['cvs_examination_remarks'])){ ?>
<tr><td style="font-style:italic;">Other Remarks:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['cvs_examination_remarks']); ?></td></tr>
<?php } ?>
</tbody></table>
<?php //} ?>

<table><thead><tr><th>PA</th></tr></thead><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody valign="top">
<?php if(!empty($examination['pa_state'])){ ?>
<tr><td style="font-style:italic;">State:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pa_state']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pa_scars'])){ ?>
<tr><td style="font-style:italic;">Scars:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pa_scars']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pa_moving_with_respiration'])){ ?>
<tr><td style="font-style:italic;">Moving with Respiration:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pa_moving_with_respiration']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pa_tender'])){ ?>
<tr><td style="font-style:italic;">Tender:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pa_tender']); 
if (isset($examination['pa_tender_describe'])) echo " (".str_replace("\n", "<br />", $examination['pa_tender_describe']).") "; ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pa_rebound_tenderness'])){ ?>
<tr><td style="font-style:italic;">Rebound Tenderness:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pa_rebound_tenderness']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pa_rigidity'])){ ?>
<tr><td style="font-style:italic;">Rigidity:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pa_rigidity']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pa_guarding'])){ ?>
<tr><td style="font-style:italic;">Guarding:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pa_guarding']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pa_organomegaly'])){ ?>
<tr><td style="font-style:italic;">Organomegaly:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pa_organomegaly']); 
if (isset($examination['pa_organomegaly_describe'])) echo " (".str_replace("\n", "<br />", $examination['pa_organomegaly_describe']).") "; ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pa_percussion'])){ ?>
<tr><td style="font-style:italic;">Percussion:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pa_percussion']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pa_bowel_sounds'])){ ?>
<tr><td style="font-style:italic;">Bowel Sounds:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pa_bowel_sounds']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pa_examination_remarks'])){ ?>
<tr><td style="font-style:italic;">Other Remarks:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pa_examination_remarks']); ?></td></tr>
<?php } ?>
</tbody></table>

<?php if(!empty($examination['git'])){ ?>
<table><thead><tr><th>GIT</th></tr></thead><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody><tr><td><?php echo str_replace("\n", "<br />", $examination['git']); ?></td></tr></tbody></table>
<?php } ?>
<?php if(!empty($examination['gut'])){ ?>
<table><thead><tr><th>GUT</th></tr></thead><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody><tr><td><?php echo str_replace("\n", "<br />", $examination['gut']); ?></td></tr></tbody></table>
<?php } ?>

<table><thead><tr><th>Pelvic Assessment</th></tr></thead><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody valign="top">
<?php if(!empty($examination['pelvic_female']) && $gender == 'female'){ ?>
<tr><td style="font-style:italic;">Remarks:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pelvic_female']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pelvic_scrotum'])){ ?>
<tr><td style="font-style:italic;">Scrotum:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pelvic_scrotum']); 
if (isset($examination['pelvic_scrotum_describe'])) echo " (".str_replace("\n", "<br />", $examination['pelvic_scrotum_describe']).") "; ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pelvic_testes'])){ ?>
<tr><td style="font-style:italic;">Testes:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pelvic_testes']); 
if (isset($examination['pelvic_testes_describe'])) echo " (".str_replace("\n", "<br />", $examination['pelvic_testes_describe']).") "; ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pelvic_penis'])){ ?>
<tr><td style="font-style:italic;">Penis:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pelvic_penis']); 
if (isset($examination['pelvic_penis_describe'])) echo " (".str_replace("\n", "<br />", $examination['pelvic_penis_describe']).") "; ?></td></tr>
<?php } ?>
<?php if(!empty($examination['pelvic_examination_remarks'])){ ?>
<tr><td style="font-style:italic;">Other Remarks:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['pelvic_examination_remarks']); ?></td></tr>
<?php } ?>
</tbody></table>

<?php //if(!empty($examination['msk'])){ ?>
<table><thead><tr><th>MSK</th></tr></thead><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody valign="top">
<?php if(!empty($examination['msk_upper_limbs'])){ ?>
<tr><td style="font-style:italic;">Upper Limbs:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['msk_upper_limbs']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['msk_lower_limbs'])){ ?>
<tr><td style="font-style:italic;">Lower Limbs:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['msk_lower_limbs']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['msk_tone'])){ ?>
<tr><td style="font-style:italic;">Tone:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['msk_tone']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['msk_bulk'])){ ?>
<tr><td style="font-style:italic;">Bulk:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['msk_bulk']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['msk_power_grade'])){ ?>
<tr><td style="font-style:italic;">Power Grade:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['msk_power_grade']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['msk_examination_remarks'])){ ?>
<tr><td style="font-style:italic;">Other Remarks:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['msk_examination_remarks']); ?></td></tr>
<?php } ?>
</tbody></table>
<?php //} ?>

<?php //if(!empty($examination['eye'])){ ?>
<table><thead><tr><th>Eye</th></tr></thead><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody valign="top">
<?php if(!empty($examination['eye_vision_re'])){ ?>
<tr><td style="font-style:italic;">Vision(RE):&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['eye_vision_re']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['eye_vision_le'])){ ?>
<tr><td style="font-style:italic;">Vision(LE):&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['eye_vision_le']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['eye_lids'])){ ?>
<tr><td style="font-style:italic;">Lids:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['eye_lids']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['eye_cornea'])){ ?>
<tr><td style="font-style:italic;">Cornea:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['eye_cornea']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['eye_ac'])){ ?>
<tr><td style="font-style:italic;">A/C:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['eye_ac']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['eye_pupil'])){ ?>
<tr><td style="font-style:italic;">Pupil:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['eye_pupil']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['eye_pupil'])){ ?>
<tr><td style="font-style:italic;">Pupil:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['eye_pupil']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['eye_retina'])){ ?>
<tr><td style="font-style:italic;">Retina:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['eye_retina']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['eye_disc'])){ ?>
<tr><td style="font-style:italic;">Disc:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['eye_disc']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['eye_macula'])){ ?>
<tr><td style="font-style:italic;">Macula:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['eye_macula']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['eye_examination_remarks'])){ ?>
<tr><td style="font-style:italic;">Other Remarks:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['eye_examination_remarks']); ?></td></tr>
<?php } ?>
</tbody></table>
<?php //} ?>

<?php if(!empty($examination['ent'])){ ?>
<table><thead><tr><th>ENT</th></tr></thead><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody><tr><td><?php echo str_replace("\n", "<br />", $examination['ent']); ?></td></tr></tbody></table>
<?php } ?>

<?php if(!empty($examination['skin'])){ ?>
<table><thead><tr><th>Skin</th></tr></thead><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody><tr><td><?php echo str_replace("\n", "<br />", $examination['skin']); ?></td></tr></tbody></table>
<?php } ?>

<?php /*if(!empty($examination['obst_gyn'])){ */if ($gender=='female'){?>
<table><thead><tr><th>Obstetrics and Gynaecology</th></tr></thead><tfoot><tr><td>&nbsp;</td></tr></tfoot>
<tbody valign="top">
<?php if(!empty($examination['obst_gyn_scar'])){ ?>
<tr><td style="font-style:italic;">Scar:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['obst_gyn_scar']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['obst_gyn_fundal_height'])){ ?>
<tr><td style="font-style:italic;">Fundal Height:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['obst_gyn_fundal_height']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['obst_gyn_presentation'])){ ?>
<tr><td style="font-style:italic;">Presentation:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['obst_gyn_presentation']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['obst_gyn_lie'])){ ?>
<tr><td style="font-style:italic;">Lie:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['obst_gyn_lie']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['obst_gyn_engagement'])){ ?>
<tr><td style="font-style:italic;">Engagement:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['obst_gyn_engagement']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['obst_gyn_fetal_heart_rate'])){ ?>
<tr><td style="font-style:italic;">Fetal Heart Rate:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['obst_gyn_fetal_heart_rate']); ?></td></tr>
<?php } ?>
<?php if(!empty($examination['obst_gyn_examination_remarks'])){ ?>
<tr><td style="font-style:italic;">Other Remarks:&emsp;</td><td><?php echo str_replace("\n", "<br />", $examination['obst_gyn_examination_remarks']); ?></td></tr>
<?php } ?>
</tbody></table>

<?php } ?>
<hr />
<?php } ?>

<?php if(!empty($diagnoses)){ ?>
<div id="examination_header_bar">Diagnosis</div>
<ul>
<?php
foreach(array_reverse($diagnoses, true) as $line=>$item){
	$cur_item_info = $this->Consultation->get_diagnosis_info($item['diagnosis_code']);
?>
<li><?php echo empty($item['description'])?$cur_item_info->description:$item['description']; ?></li>
<?php } ?>
</ul>
<p>&nbsp;</p>
<hr />
<?php } ?>

