<?php
class MJ_lawmgt_Orders/*<---START MJ_lawmgt_Orders CLASS--->*/
{
    /*<--- Add Judgments FUNCTION --->*/
    public function MJ_lawmgt_add_order($data, $document_url)
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $order_data['date'] = sanitize_text_field(date('Y-m-d', strtotime($data['date'])));
        $order_data['case_id'] = sanitize_text_field($data['case_id']);
        $order_data['judge_name'] = sanitize_text_field($data['judge_name']);
        $order_data['orders_details'] = sanitize_textarea_field($data['orders_details']);
        $order_data['next_hearing_date'] = sanitize_text_field(date('Y-m-d', strtotime($data['next_hearing_date'])));
        $order_data['purpose_of_hearing'] = sanitize_textarea_field($data['purpose_of_hearing']);

        if (esc_attr($data['action'])== 'edit') {
            $order_id['id'] = sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
            $order_data['updated_date'] = date("Y-m-d H:i:s");
            //------ multiple document with title ---//
            $document_data = array();
            if (!empty($document_url)) {
                foreach ($document_url as $key => $value) {
                    $document_data[] = array('title' => sanitize_text_field($data['document_name'][$key]), 'value' => $value);
                }
            }
            $order_data['orders_document'] = json_encode($document_data);
            $result = $wpdb->update($table_lmgt_orders, $order_data, $order_id);
            if ($result) {
                //send order mail //
                $contact_attorney_data = MJ_lawmgt_get_contact_and_attorney_data_by_case_id($data['case_id']);

                foreach ($contact_attorney_data as $user_id) {
                    $system_name = get_option('lmgt_system_name');

                    $userdata = get_userdata($user_id);
                    $to = $userdata->user_email;
                    $arr['{{Lawyer System Name}}'] = $system_name;
                    $arr['{{User Name}}'] = $userdata->display_name;
                    $arr['{{Case Name}}'] = MJ_lawmgt_get_case_name($data['case_id']);
                    $arr['{{Case Number}}'] = MJ_lawmgt_get_case_number($data['case_id']);
                    $arr['{{Judge Name}}'] = sanitize_text_field($data['judge_name']);
                    $arr['{{Next Hearing Date}}'] = sanitize_text_field($data['next_hearing_date']);
                    $arr['{{Order Details}}'] = sanitize_textarea_field($data['orders_details']);

                    $subject = get_option('lmgt_updated_order_email_subject');
                    $subject_replacement = MJ_lawmgt_string_replacemnet($arr, $subject);
                    $message = get_option('lmgt_updated_order_email_template');
                    $message_replacement = MJ_lawmgt_string_replacemnet($arr, $message);

                    MJ_lawmgt_send_mail($to, $subject_replacement, $message_replacement);
                }

                //audit Log
                $case_id = sanitize_text_field($data['case_id']);
                $case_name = MJ_lawmgt_get_case_name($case_id);
                $case_link = '<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=' . MJ_lawmgt_id_encrypt(esc_attr($case_id)) . '">' . esc_html($case_name) . '</a>';
                $judge_name = sanitize_text_field($data['judge_name']);
                $updated_order = esc_html__('Updated Order Of ', 'lawyer_mgt');
                MJ_lawmgt_append_audit_log($updated_order . ' ' . $judge_name, get_current_user_id(), $case_link);
                MJ_lawmgt_append_audit_log_for_downlaod($updated_order . ' ' . $judge_name, get_current_user_id(), '');
                MJ_lawmgt_append_audit_log_for_downlaod($updated_order . ' ' . $judge_name, get_current_user_id(), '');
                MJ_lawmgt_append_audit_order_log($updated_order . ' ' . $judge_name, get_current_user_id(), $case_link);
                MJ_lawmgt_append_audit_caselog($updated_order . ' ' . $judge_name, get_current_user_id(), $case_link);
                MJ_lawmgt_userwise_activity($updated_order . ' ' . $judge_name, get_current_user_id(), $case_link);

                MJ_lawmgt_append_audit_caselog_download($updated_order . ' ' . $judge_name, get_current_user_id());
                MJ_lawmgt_append_audit_order_log_download($updated_order . ' ' . $judge_name, get_current_user_id());

            }
            return $result;
        } else {
            //------ multiple document with title ---//
            $document_data = array();
            if (!empty($document_url)) {
                foreach ($document_url as $key => $value) {
                    $document_data[] = array('title' => sanitize_text_field($data['document_name'][$key]), 'value' => $value);
                }
            }
            $order_data['orders_document'] = json_encode($document_data);

            //------ multiple document with title ---//

            $order_data['created_date'] = date("Y-m-d H:i:s");
            $order_data['created_by'] = get_current_user_id();
            $result = $wpdb->insert($table_lmgt_orders, $order_data);
            $last = $wpdb->insert_id;

            if ($result) {
                //send order mail //
                $contact_attorney_data = MJ_lawmgt_get_contact_and_attorney_data_by_case_id(sanitize_text_field($data['case_id']));

                foreach ($contact_attorney_data as $user_id) {
                    $system_name = get_option('lmgt_system_name');

                    $userdata = get_userdata(sanitize_text_field($user_id));
                    $to = sanitize_email($userdata->user_email);
                    $arr['{{Lawyer System Name}}'] = $system_name;
                    $arr['{{User Name}}'] = sanitize_text_field($userdata->display_name);
                    $arr['{{Case Name}}'] = MJ_lawmgt_get_case_name(sanitize_text_field($data['case_id']));
                    $arr['{{Case Number}}'] = MJ_lawmgt_get_case_number(sanitize_text_field($data['case_id']));
                    $arr['{{Judge Name}}'] = sanitize_text_field($data['judge_name']);
                    $arr['{{Next Hearing Date}}'] = sanitize_text_field($data['next_hearing_date']);
                    $arr['{{Order Details}}'] = sanitize_textarea_field($data['orders_details']);

                    $subject = get_option('lmgt_order_email_subject');
                    $subject_replacement = MJ_lawmgt_string_replacemnet($arr, $subject);
                    $message = get_option('lmgt_order_email_template');
                    $message_replacement = MJ_lawmgt_string_replacemnet($arr, $message);

                    MJ_lawmgt_send_mail($to, $subject_replacement, $message_replacement);
                }
                //audit Log
                $case_id = $data['case_id'];
                $case_name = MJ_lawmgt_get_case_name($case_id);
                $case_link = '<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=' . MJ_lawmgt_id_encrypt(esc_attr($case_id)) . '">' . esc_html($case_name) . '</a>';
                $judge_name = sanitize_text_field($data['judge_name']);
                $added_order = esc_html__('Added New Order Of ', 'lawyer_mgt');
                MJ_lawmgt_append_audit_log($added_order . ' ' . $judge_name, get_current_user_id(), $case_link);
                MJ_lawmgt_append_audit_log_for_downlaod($added_order . ' ' . $judge_name, get_current_user_id(), '');
                MJ_lawmgt_append_audit_order_log($added_order . ' ' . $judge_name, get_current_user_id(), $case_link);
                MJ_lawmgt_append_audit_caselog($added_order . ' ' . $judge_name, get_current_user_id(), $case_link);
                MJ_lawmgt_userwise_activity($added_order . ' ' . $judge_name, get_current_user_id(), $case_link);
                MJ_lawmgt_append_audit_caselog_download($added_order . ' ' . $judge_name, get_current_user_id());
                MJ_lawmgt_append_audit_order_log_download($added_order . ' ' . $judge_name, get_current_user_id());

            }
        }
        return $result;
    }
    /*<--- GET All Judgements  FUNCTION--->*/
    public function MJ_lawmgt_get_all_orders()
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';

        $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where deleted_status=0 ORDER BY id DESC");
        return $result;

    }
    /*<--- GET All Judgements  FUNCTION--->*/
    public function MJ_lawmgt_get_all_own_orders()
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $user_id = get_current_user_id();
        $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where deleted_status=0 AND created_by=$user_id ORDER BY id DESC");
        return $result;

    }
    /*<--- GET All Judgements  By Attorney FUNCTION--->*/
    public function MJ_lawmgt_get_all_orders_by_attorney()
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $table_case = $wpdb->prefix . 'lmgt_cases';

        $attorney_id = get_current_user_id();

        $casedata = $wpdb->get_results("SELECT * FROM $table_case where FIND_IN_SET($attorney_id,case_assgined_to)");
        $case_id = array();
        if (!empty($casedata)) {
            foreach ($casedata as $data) {
                $case_id[] = $data->id;
            }
        }
        if (!empty($case_id)) {
            $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where deleted_status=0 AND (case_id IN (" . implode(',', $case_id) . ") OR created_by=$attorney_id)");
        } else {
            $result = '';
        }
        return $result;

    }
    /*<--- GET All Judgements  By Client FUNCTION--->*/
    public function MJ_lawmgt_get_all_orders_by_client()
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $table_case_contact = $wpdb->prefix . 'lmgt_case_contacts';

        $user_id = get_current_user_id();

        $casedata = $wpdb->get_results("SELECT * FROM $table_case_contact where user_id=$user_id");
        $case_id = array();
        if (!empty($casedata)) {
            foreach ($casedata as $data) {
                $case_id[] = $data->case_id;
            }
        }
        if (!empty($case_id)) {
            $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where (deleted_status=0) AND (case_id IN (" . implode(',', $case_id) . ") OR created_by=$user_id)");
        } else {
            $result = '';
        }
        return $result;
    }
    /*<--- GET SINGLE Judgement FUNCTION--->*/
    public function MJ_lawmgt_get_single_orders($id)
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $result = $wpdb->get_row("SELECT * FROM $table_lmgt_orders where id=" . $id);

        return $result;
    }
    /*<--- DELETE Judgement  FUNCTION--->*/
    public function MJ_lawmgt_delete_orders($id)
    {
        //audit Log
        $order = new MJ_lawmgt_Orders;
        $orderdata = $order->MJ_lawmgt_get_single_orders(sanitize_text_field(MJ_lawmgt_id_decrypt($id)));
        $case_id = $orderdata->case_id;
        $case_name = MJ_lawmgt_get_case_name($case_id);
        $case_link = '<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=' . MJ_lawmgt_id_encrypt(esc_attr($case_id)) . '">' . esc_html($case_name) . '</a>';
        $judge_name = $orderdata->judge_name;

        $added_order = esc_html__('Deleted  Order Of ', 'lawyer_mgt');
        MJ_lawmgt_append_audit_log($added_order . ' ' . $judge_name, get_current_user_id(), $case_link);
        MJ_lawmgt_append_audit_order_log($added_order . ' ' . $judge_name, get_current_user_id(), $case_link);
        MJ_lawmgt_append_audit_caselog($added_order . ' ' . $judge_name, get_current_user_id(), $case_link);
        MJ_lawmgt_userwise_activity($added_order . ' ' . $judge_name, get_current_user_id(), $case_link);

        MJ_lawmgt_append_audit_caselog_download($added_order . ' ' . $judge_name, get_current_user_id());
        MJ_lawmgt_append_audit_order_log_download($added_order . ' ' . $judge_name, get_current_user_id());

        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $order_data['deleted_status'] = 1;
        $whereid['id'] = sanitize_text_field(MJ_lawmgt_id_decrypt($id));
        $result = $wpdb->update($table_lmgt_orders, $order_data, $whereid);

        return $result;

    }
/*<--- GET ALL CASEORDERS  DASHBOEARD FUNCTION --->*/
    public function MJ_lawmgt_get_all_orders_dashboard()
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';

        $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where deleted_status=0 AND date<=CURDATE() ORDER BY date limit 5");
        return $result;

    }
    /*<--- GET ALL CASEORDERS  DASHBOEARD Created by FUNCTION --->*/
    public function MJ_lawmgt_get_all_orders_dashboard_created_by()
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $current_user_id = get_current_user_id();
        $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where deleted_status=0 AND created_by=$current_user_id AND date<=CURDATE() ORDER BY date limit 5");
        return $result;

    }
    /*<--- GET Attorney ALL  ORDER DASHBOAERD FUNCTION --->*/
    public function MJ_lawmgt_get_attorney_all_orders_dashboard()
    {

        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $table_case = $wpdb->prefix . 'lmgt_cases';
        $attorney_id = get_current_user_id();

        $casedata = $wpdb->get_results("SELECT * FROM $table_case where FIND_IN_SET($attorney_id,case_assgined_to) OR created_by=$attorney_id");
        $case_id = array();
        if (!empty($casedata)) {
            foreach ($casedata as $data) {
                $case_id[] = $data->id;
            }
        }
        if (!empty($case_id)) {
            $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where (deleted_status=0) AND (date<=CURDATE()) AND (case_id IN (" . implode(',', $case_id) . ") OR created_by=$attorney_id) ORDER BY date limit 5");
        } else {
            $result = '';
        }
        return $result;
    }
    /*<--- GET ALL ORDER BY CLIENT DASHBOARD FUNCTION --->*/
    public function MJ_lawmgt_get_contact_all_orders_dashboard()
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $table_case_contact = $wpdb->prefix . 'lmgt_case_contacts';

        $user_id = get_current_user_id();

        $casedata = $wpdb->get_results("SELECT * FROM $table_case_contact where user_id=$user_id");
        $case_id = array();
        if (!empty($casedata)) {
            foreach ($casedata as $data) {
                $case_id[] = $data->case_id;
            }
        }
        if (!empty($case_id)) {
            $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where (deleted_status=0) AND (date<=CURDATE()) AND (case_id IN (" . implode(',', $case_id) . ") OR created_by=$user_id) ORDER BY date limit 5");
        } else {
            $result = '';
        }
        return $result;
    }
    /*<--- GET ALL Orders By Case FUNCTION --->*/
    public function MJ_lawmgt_get_case_wise_orders($case_id)
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';

        $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where deleted_status=0 AND case_id=$case_id");
        return $result;

    }
/*<--- GET  Hearing DATE By Case FUNCTION --->*/
    public function MJ_lawmgt_get_next_hearing_date_by_case_id($case_id)
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $data_array = array();
        $result = $wpdb->get_results("SELECT next_hearing_date FROM $table_lmgt_orders where case_id=$case_id AND deleted_status=0");
        if (!empty($result)) {
            foreach ($result as $data) {
                $data_array[] = $data->next_hearing_date;
            }
        }
        return $result;
    }
/*<--- GET  Hearing DATE By Case `next_hearing_date` ASC FUNCTION --->*/
    public function MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id)
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $data_array = array();
        $result = $wpdb->get_results("SELECT next_hearing_date FROM $table_lmgt_orders where case_id=$case_id AND deleted_status=0 ORDER BY next_hearing_date ASC");
        if (!empty($result)) {
            foreach ($result as $data) {
                $data_array[] = $data->next_hearing_date;
            }
        }
        return $result;
    }
/*<--- GET ALL  ALL  Next Hearing date BY CASE ID  FUNCTION --->*/
    public function MJ_lawmgt_get_casewise_all_next_hearing_date($case_id)
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';

        $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where case_id=$case_id AND deleted_status=0 ORDER BY next_hearing_date ASC");
        return $result;
    }
    /*<--- GET ALL  Next Hearing Date DASHBOAERD FUNCTION --->*/
    public function MJ_lawmgt_get_next_hearing_date_dashboard()
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $current_date = date('Y-m-d');

        $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where deleted_status=0 AND next_hearing_date >= '$current_date' ORDER BY next_hearing_date limit 5");

        return $result;
    }
    /*<--- GET ALL  Next Hearing Date DASHBOAERD Created by FUNCTION --->*/
    public function MJ_lawmgt_get_next_hearing_date_dashboard_created_by()
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $current_date = date('Y-m-d');
        $current_user_id = get_current_user_id();
        $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where deleted_status=0 AND created_by=$current_user_id AND next_hearing_date >= '$current_date' ORDER BY next_hearing_date limit 5");

        return $result;
    }
    /*<--- GET Attorney ALL  ORDER DASHBOAERD FUNCTION --->*/
    public function MJ_lawmgt_get_attorney_all_next_hearing_date_dashboard()
    {

        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $table_case = $wpdb->prefix . 'lmgt_cases';
        $attorney_id = get_current_user_id();

        $casedata = $wpdb->get_results("SELECT * FROM $table_case where FIND_IN_SET($attorney_id,case_assgined_to)");
        $case_id = array();
        if (!empty($casedata)) {
            foreach ($casedata as $data) {
                $case_id[] = $data->id;
            }
        }
        if (!empty($case_id)) {
            $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where (deleted_status=0) AND (next_hearing_date >= CURDATE()) AND (case_id IN (" . implode(',', $case_id) . ") OR created_by=$attorney_id) ORDER BY next_hearing_date limit 5");
        } else {
            $result = '';
        }
        return $result;
    }
    /*<--- GET ALL ORDER BY CLIENT DASHBOARD FUNCTION --->*/
    public function MJ_lawmgt_get_contact_all_next_hearing_date_dashboard()
    {
        global $wpdb;
        $table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
        $table_case_contact = $wpdb->prefix . 'lmgt_case_contacts';

        $user_id = get_current_user_id();

        $casedata = $wpdb->get_results("SELECT * FROM $table_case_contact where user_id=$user_id");
        $case_id = array();
        if (!empty($casedata)) {
            foreach ($casedata as $data) {
                $case_id[] = $data->case_id;
            }
        }
        if (!empty($case_id)) {
            $result = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where (deleted_status=0) AND (next_hearing_date >= CURDATE()) AND (case_id IN (" . implode(',', $case_id) . ") OR created_by=$user_id) ORDER BY next_hearing_date limit 5");
        } else {
            $result = '';
        }
        return $result;
    }
} /*<---END  MJ_lawmgt_Orders  CLASS--->*/
