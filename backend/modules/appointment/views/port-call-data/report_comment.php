<?php ?>
<html>
    <head>
    </head>
    <body>

        <div class="row">
            <div class="col-md-12">
                <?php if (!empty($model)) { ?>
                    <table style="width: 100%;border: 1px solid #333;border-collapse: collapse;">
                        <tr>
                            <th style="border: 1px solid #333;white-space:nowrap;padding: 6px 10px;text-align: left;">User Name</th>
                            <th style="border: 1px solid #333;white-space:nowrap;padding: 6px 10px;text-align: left;">Date</th>
                            <th style="border: 1px solid #333;white-space:nowrap;padding: 6px 10px;text-align: left;">Department</th>
                            <th style="border: 1px solid #333;white-space:nowrap;padding: 6px 10px;text-align: left;">Assigned To</th>
                            <th style="border: 1px solid #333;white-space:nowrap;padding: 6px 10px;text-align: left;">Comments</th>
                        </tr>
                        <?php
                        foreach ($model as $data) {
                            ?>
                            <tr>
                                <td style="border: 1px solid #333;padding: 6px 10px;"><?= \common\models\Employee::findOne(['id' => $data->user_id])->name ?></td>
                                <td style="border: 1px solid #333;padding: 6px 10px;"><?= $data->comment_date ?></td>
                                <td style="border: 1px solid #333;padding: 6px 10px;">
                                    <?php
                                    if ($data->department == '') {
                                        echo '';
                                    } elseif ($data->department == 1) {
                                        echo 'Common';
                                    } elseif ($data->department == 2) {
                                        echo 'Operations';
                                    } elseif ($data->department == 3) {
                                        echo 'Accounts';
                                    }
                                    ?>
                                </td>
                                <td style="border: 1px solid #333;padding: 6px 10px;">
                                    <?php
                                    if (isset($data->assigned_to) && $data->assigned_to != '') {
                                        echo common\models\Employee::findOne($data->assigned_to)->name;
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </td>
                                <td style="border: 1px solid #333;padding: 6px 10px;"><?= $data->comment ?></td>
                            </tr>
                        <?php }
                        ?>
                    </table>
                <?php }
                ?>
            </div>
        </div>
    </body>
</html>
