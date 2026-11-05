        <aside id="sidebar" class="grid_3 pull_9">

            <script type="text/javascript">
            $(document).ready(function() {

                $('#ajaxPost').click(function() {

                    $('#frmSearch').submit();

                });

            });
            </script>

            <?php 

                        if(isset($left_box))

                        { 

                                if(count($left_box))

                                {				   

                                        foreach($left_box as $lb):					

                                                switch($lb){



                                                        case 'report':

                                                                $this->load->view('common/report/innovation_report_left');

                                                                break;

                                                        case 'innovation_pool':

                                                                $this->load->view('scouting/innovation_pool_left');

                                                                break;

                                                        case 'innovation_tab':

                                                                $this->load->view('scouting/innovation_tab');

                                                                break;

                                                        case 'screening':

                                                                $this->load->view('screening/screening_left_menu');

                                                                break;

                                                        case 'master':

                                                                $this->load->view('master/left_menu');

                                                                break;

                                                        case 'incubation':

                                                                $this->load->view('seedfunding/incubation_services');

                                                                break;

                                                        case 'ajax_left_box':

                                                                        $this->load->view('common/dashboard/ajax_left'); 

                                                                        break;





                                                }

                                        endforeach;

                                }

			}

			?>

        </aside>