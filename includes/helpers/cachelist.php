<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}
class SI_IMDB_Cache_List_Table extends WP_List_Table {

    public function get_cache($per_page = 5, $page_number = 1 , $search_term=""){
        global $wpdb;

        if($search_term == "") {
            $sql = "SELECT * FROM {$wpdb->prefix}imdb_cache";

            if (!empty($_REQUEST['orderby'])) {
                $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
                $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
            }


            $sql .= " LIMIT $per_page";

            $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;


            $result = $wpdb->get_results($sql);
            $data = array();
            foreach ($result as $k => $r) {
                $data[$k]['id'] = $r->id;
                $data[$k]['imdb_id'] = $r->imdb_id;
                $data[$k]['title'] = $r->title;
                $data[$k]['type'] = $r->type;
            }
        }else{
            $sql = "SELECT * FROM ".$wpdb->prefix."imdb_cache WHERE imdb_id='".$search_term."' OR title LIKE '%".$search_term."%'";
            $result = $wpdb->get_results($sql);
            $data = array();
            foreach ($result as $k => $r) {
                $data[$k]['id'] = $r->id;
                $data[$k]['imdb_id'] = $r->imdb_id;
                $data[$k]['title'] = $r->title;
                $data[$k]['type'] = $r->type;
            }
        }

        return $data;
    }

    public function get_columns(){
        $columns = array(
            'cb'      => '<input type="checkbox" />',
            'id'      => __('<b>ID</b>','sp'),
            'title' => __('<b>Title</b>','sp'),
            'type'      => __('<b>Type</b>','sp'),
            'imdb_id'    => __('<b>IMDB ID</b>','sp')
        );
        return $columns;
    }

    public function prepare_items() {
        global $wpdb;

        $search_terms = isset($_POST['s']) ? trim($_POST['s']) : "";
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $current_page = $this->get_pagenum();
        $sql = "SELECT COUNT(id) FROM {$wpdb->prefix}imdb_cache";
        $total_items = $wpdb->get_var($sql);
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => 50
        ));
        $this->items = $this->get_cache(50,$current_page, $search_terms);
    }
    public function column_default( $item, $column_name ) {
        switch( $column_name ) {
            case 'id':
            case 'title':
            case 'type':
            case 'imdb_id':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
        }
    }

    public function get_sortable_columns()
    {
        return array(
            "id" => array("id",true),
            "title" => array("title",false),
            "type" => array("type",false),
            "imdb_id" => array("imdb_id",false),
        );
    }

    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
        );
    }

    public function get_bulk_actions() {
        $actions = array(
            'bulk-delete' => 'Delete'
        );

        return $actions;
    }

    public function column_name( $item ) {

        // create a nonce
        $delete_nonce = wp_create_nonce( 'sp_delete_customer' );

        $title = '<strong>' . $item['title'] . '</strong>';

        $actions = array(
            'delete' => sprintf( '<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce )
        );

        return $title . $this->row_actions( $actions );
    }

    public function process_bulk_action() {

        //Detect when a bulk action is being triggered...
        if ( 'delete' === $this->current_action() ) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );

            if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                self::delete_customer( absint( $_GET['customer'] ) );

                wp_redirect( esc_url( add_query_arg() ) );
                exit;
            }

        }

        // If the delete bulk action is triggered
        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
            || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
        ) {

            $delete_ids = esc_sql( $_POST['bulk-delete'] );

            // loop over the array of record IDs and delete them
            foreach ( $delete_ids as $id ) {
                self::delete_customer( $id );

            }

            wp_redirect( esc_url( add_query_arg() ) );
            exit;
        }
    }

    public function delete_customer( $id ) {
        global $wpdb;

        $wpdb->delete(
            "{$wpdb->prefix}imdb_cache",
            array( 'id' => $id ),
            array( '%d' )
        );

    }

}
