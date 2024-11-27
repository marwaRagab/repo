<template>
  <div>
    <h1>Nationalities</h1>

    <!-- Button to trigger the create modal -->
    <button type="button" class="btn btn-primary" @click="openCreateModal">
      Create Nationality
    </button>

    <!-- Modal for Creating a New Nationality -->
    <div v-if="showCreateModal" class="modal fade show d-block" tabindex="-1" aria-labelledby="createNationalityModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createNationalityModalLabel">Create Nationality</h5>
            <button type="button" class="btn-close" @click="closeCreateModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="createNationality">
              <div class="mb-3">
                <label for="nationalityName" class="form-label">Nationality Name AR</label>
                <input type="text" class="form-control" id="nationalityName" v-model="newNationality.name_ar" name="name_ar" required>
              </div>
              <div class="mb-3">
                <label for="nationalityNameEN" class="form-label">Nationality Name EN</label>
                <input type="text" class="form-control" id="nationalityNameEN" v-model="newNationality.name_en" name="name_en" required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeCreateModal">Close</button>
                <button type="submit" class="btn btn-primary">Save Nationality</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for Editing a Nationality -->
    <div v-if="showEditModal" class="modal fade show d-block" tabindex="-1" aria-labelledby="editNationalityModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editNationalityModalLabel">Edit Nationality</h5>
            <button type="button" class="btn-close" @click="closeEditModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateNationality">
              <div class="mb-3">
                <label for="editNationalityName" class="form-label">Nationality Name</label>
                <input type="text" class="form-control" id="editNationalityName" v-model="editNationality.name" name="name" required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeEditModal">Close</button>
                <button type="submit" class="btn btn-primary">Update Nationality</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for Showing Nationality Details -->
    <div v-if="showDetailsModal" class="modal fade show d-block" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="detailsModalLabel">Nationality Details</h5>
            <button type="button" class="btn-close" @click="closeDetailsModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p><strong>ID:</strong> {{ nationalityDetails.id }}</p>
            <p><strong>Name:</strong> {{ nationalityDetails.name }}</p>
            <p><strong>Created At:</strong> {{ nationalityDetails.created_at }}</p>
            <p><strong>Updated At:</strong> {{ nationalityDetails.updated_at }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeDetailsModal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <table id="nationalityTable" class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name ar</th>
          <th>Name en</th>
          <th>Created At</th>
          <th>Updated At</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import $ from 'jquery';
import 'datatables.net-bs5';
import axios from 'axios';
import { useToast } from 'vue-toastification';

const toast = useToast();
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDetailsModal = ref(false);
const newNationality = ref({ name: '' });
const editNationality = ref({ id: null, name: '' });
const nationalityDetails = ref(null);

const openCreateModal = () => {
  showCreateModal.value = true;
};

const closeCreateModal = () => {
  showCreateModal.value = false;
  newNationality.value = { name: '' }; // Reset form data
};

const openEditModal = (id, name) => {
  showEditModal.value = true;
  editNationality.value = { id, name };
};

const closeEditModal = () => {
  showEditModal.value = false;
  editNationality.value = { id: null, name: '' }; // Reset form data
};

const openDetailsModal = (id) => {
  fetchNationalityDetails(id);
  showDetailsModal.value = true;
};

const closeDetailsModal = () => {
  showDetailsModal.value = false;
  nationalityDetails.value = null; // Reset details data
};

const createNationality = async () => {
  try {
    await axios.post('/nationalities', newNationality.value);
    $('#nationalityTable').DataTable().ajax.reload(); // Reload table
    closeCreateModal(); // Close modal
    toast.success('Nationality created successfully!');
  } catch (error) {
    console.error('Error creating nationality:', error);
    toast.error('Failed to create nationality.');
  }
};

const updateNationality = async () => {
  try {
    await axios.put(`/nationalities/${editNationality.value.id}`, editNationality.value);
    $('#nationalityTable').DataTable().ajax.reload(); // Reload table
    closeEditModal(); // Close modal
    toast.success('Nationality updated successfully!');
  } catch (error) {
    console.error('Error updating nationality:', error);
    toast.error('Failed to update nationality.');
  }
};

const fetchNationalityDetails = async (id) => {
  try {
    const response = await axios.get(`/nationalities/${id}`);
    nationalityDetails.value = response.data;
  } catch (error) {
    console.error('Error fetching nationality details:', error);
    toast.error('Failed to fetch nationality details.');
  }
};

const deleteNationality = async (id) => {
  if (confirm('Are you sure you want to delete this nationality?')) {
    try {
      await axios.delete(`/nationalities/${id}`);
      $('#nationalityTable').DataTable().ajax.reload();
      toast.success('Nationality deleted successfully!');
    } catch (error) {
      console.error('Error deleting nationality:', error);
      toast.error('Failed to delete nationality.');
    }
  }
};

onMounted(() => {
  const table = $('#nationalityTable').DataTable({
    processing: true,
    serverSide: true,
    // ajax: '/nationalities',
    ajax: {
              url: '/nationalities',
              // type: 'GET',
          },
    columns: [
      { data: 'id', name: 'id' },
      { data: 'name_ar', name: 'name_ar' },
      { data: 'name_en', name: 'name_en' },
      { data: 'created_at', name: 'created_at' },
      { data: 'updated_at', name: 'updated_at' },
      {
        data: null,
        name: 'action',
        orderable: false,
        searchable: false,
        render: (data, type, row) => {
          return `
            <button class="btn btn-info show-btn" data-id="${row.id}">Show</button>
            <button class="btn btn-warning edit-btn" data-id="${row.id}" data-name="${row.name}">Edit</button>
            <button class="btn btn-danger delete-btn" data-id="${row.id}">Delete</button>
          `;
        }
      }
    ],
  });

  $('#nationalityTable').on('click', '.show-btn', function () {
    const id = $(this).data('id');
    openDetailsModal(id);
  });

  $('#nationalityTable').on('click', '.edit-btn', function () {
    const id = $(this).data('id');
    const name = $(this).data('name');
    openEditModal(id, name);
  });

  $('#nationalityTable').on('click', '.delete-btn', function () {
    const id = $(this).data('id');
    deleteNationality(id);
  });
});
</script>

<style scoped>
/* You can add your styles here */
</style>
