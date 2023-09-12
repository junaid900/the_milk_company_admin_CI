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
                                <th><?=get_phrase("position")?></th>
                                <th><?=get_phrase("experience")?></th>
                                <th><?=get_phrase("job_type")?></th>
                                <th><?=get_phrase("last_time")?></th>
                                <th><?=get_phrase("actions")?></th>
                            </tr>
                            </thead>
                            <tbody class="row_position">
                            <?php
                            $i = 0;
                            if(!empty($saved_jobs)){
                            foreach ($saved_jobs as $data) {$i++; ?>
                                <tr class="gradeX">
                                    <td><?= $i ?></td>
                                    <td><img src="<?php echo base_url(); ?><?= $data['image'] ?> " alt="" /></td>
                                    <td><?= $data['position'] ?></td>
                                    <td><?= $data['experience'] ?></td>
                                    <td><?= $data['job_type'] ?></td>
                                    <td><?= $data['created_at'] ?></td>
                                    <td class="center">
                                        <a href="javascript:;"
                                           onclick="confirm_modal_action('<?php echo base_url() . admin_ctrl() ?>/<?= $page_name ?>/delete/<?php echo $data['job_id']; ?>/saved_jobs');">
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