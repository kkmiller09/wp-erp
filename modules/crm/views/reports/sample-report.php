<?php
if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ), 'erp-nonce' ) ) {
    // die();
}

$data    = [];
$total   = 0;
$url = get_site_url(null, '/wp-admin/', 'https');
$start   = !empty( $_POST['start'] ) ? sanitize_text_field( wp_unslash( $_POST['start'] ) ) : false;
$end     = !empty( $_POST['end'] ) ? sanitize_text_field( wp_unslash( $_POST['end'] ) ) : date('Y-m-d');

$reports = erp_crm_sample_reporting_query( $start, $end );

?><div class="wrap">
    <h2 class="report-title"><?php esc_attr_e( 'Sample Report', 'erp' ); ?></h2>
    <div class="erp-crm-report-header-wrap">
        <?php erp_crm_sample_report_filter_form(); ?>
        <button class="print" onclick="window.print()">Print</button>
    </div>
    <table class="table widefat striped">
        <thead>
            <tr>
                <th><?php esc_attr_e( 'Date', 'erp' ); ?></th>
                <th><?php esc_attr_e( 'Agent', 'erp' ); ?></th>
                <th><?php esc_attr_e( 'Customer', 'erp' ); ?></th>                
                <th><?php esc_attr_e( 'Details', 'erp' ); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php
                foreach ( $reports as $report ) {                  
                    $customer_url = "<a target='_blank' href=" . $url . "admin.php?page=erp-crm&section=companies&action=view&id=" . esc_attr( $report['contact']['id'] ) .">".esc_attr( $report['contact']['company'] )."</a>";
                    echo "<tr><td>" . esc_attr__( $report['created_at']) . "</td>";
                    echo "<td>" . esc_attr( $report['created_by']['display_name'] ) . "</td>";
                    echo "<td>" . $customer_url . "</td>";                    
                    echo "<td>" .  $report['message']  . "</td></tr>";

                    $total += 1;
                }
            ?>
        </tbody>

        <tfoot>
            <tr>
                <td><?php esc_attr_e('Total', 'erp') ?></td>
                <td><?php echo esc_attr( $total ); ?></td>
            </tr>
        </tfoot>
    </table>

</div>

<style>
    .report-title {
        padding-bottom: 10px !important;
    }

    .erp-crm-report-filter-form {
        float: left;
        display: flex;
    }

    .erp-crm-report-header-wrap {
        height: 25px;
    }

    .print {
        float: right;
    }

    .table.widefat.striped {
        margin-top: 10px;
    }

    @media print {
        .report-title {
            text-align: center;
        }

        .erp-crm-report-header-wrap {
            display: none;
        }

        .table.widefat.striped {
            margin-top: 20px;
        }
    }
</style>
