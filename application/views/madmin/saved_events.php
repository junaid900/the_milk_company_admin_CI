<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="">
                <div class="table-responsive">
                    <table class="dataTables-example table-striped">
                        <thead>
                        <tr>
                            <th><?="No."?></th>
                            <th><?=get_phrase("picture")?></th>
                            <th><?=get_phrase("events")?></th>
                            <th><?=get_phrase("date")?></th>
                            <th><?=get_phrase("actions")?></th>
                        </tr>
                        </thead>
                        <tbody >
                        <?php
                        $i = 0;
                        if(!empty($saved_events)){
                        foreach ($saved_events as $data) {$i++; ?>
                            <tr class="gradeX ">
                                <td><?= $i ?></td>
                                <td>
                                    <?php if(!empty($data['image'])){ ?>
                                    <img src="<?php echo base_url(); ?><?= $data['image'] ?> " alt="<?= $data['en_title'] ?>" width="50px" />
                                    <?php } ?>
                                </td>
                                <td><?= $data['en_title'] ?></td>
                                <td><?= $data['created_date'] ?></td>
                                <td class="center">
                                    <a href="javascript:;"
                                       onclick="confirm_modal_action('<?php echo base_url() . admin_ctrl() ?>/<?= $page_name ?>/delete/<?php echo $param1; ?>/saved_events');">
                                       <img src="<?=base_url(); ?>assets/admin/img/bin.png" class="mr_1" /> 
                                    </a>
                                </td>
                            </tr>
                        <?php } 
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>