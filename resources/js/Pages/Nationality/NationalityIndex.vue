<template>
  <div class="tt">
      <table id="NationalityTable" class="table table-striped w-100">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Nationality Name</th>
                  <th>Created At</th>
              </tr>
          </thead>
      </table>
  </div>
</template>

<script>
import $ from 'jquery';
import 'datatables.net-bs5';

export default {
  mounted() {
      $('#NationalityTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url: '/api/get-nationalities',
              type: 'GET',
          },
          columns: [
              { data: 'id', name: 'id' },
              { data: 'name', name: 'name' },
              { data: 'created_at', name: 'created_at' },
          ],
      });
  },
};
</script>

<style>

.tt
{
    width: 80vw;
    padding: 10ch;
}
</style>
