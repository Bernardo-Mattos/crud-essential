import $ from 'jquery';
import DataTable from 'datatables.net-dt';
import 'datatables.net-dt/css/dataTables.dataTables.css';
import 'datatables.net-responsive-dt';
import 'datatables.net-responsive-dt/css/responsive.dataTables.css';
import { showToast } from './components/toast.js';

window.$ = window.jQuery = $;
DataTable.use($);

document.addEventListener('DOMContentLoaded', () => {
    const { flashType, flashMessage } = document.body.dataset;

    if (flashType && flashMessage) {
        showToast(flashType, flashMessage);
    }
});
