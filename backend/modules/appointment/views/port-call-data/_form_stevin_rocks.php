<?= $form->field($model, 'first_line_ashore')->textInput(['tabindex' => 20]) ?>

<?= $form->field($model, 'all_fast')->textInput(['tabindex' => 21])->label('All Fast <span class="required-star"> * </span>') ?>

<?= $form->field($model, 'cargo_commenced')->textInput(['tabindex' => 22]) ?>

<?= $form->field($model, 'cargo_completed')->textInput(['tabindex' => 23]) ?>

<?= $form->field($model, 'pob_outbound')->textInput(['tabindex' => 24]) ?>

<?= $form->field($model, 'cast_off')->textInput(['tabindex' => 25])->label('Cast Off <span class="required-star"> * </span>') ?>

<?= $form->field($model, 'lastline_away')->textInput(['tabindex' => 26]) ?>


<?= $form->field($model, 'cosp')->textInput(['tabindex' => 27]) ?>


<?= $form->field($model, 'eta_next_port')->textInput(['tabindex' => 28]) ?>