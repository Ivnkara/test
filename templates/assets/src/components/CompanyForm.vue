<template>
  <div>
    <h1>{{ isEditing ? 'Edit Company' : 'New Company' }}</h1>
    <form @submit.prevent="submitForm">
      <div>
        <label for="name">Name:</label>
        <input type="text" v-model="company.name" required>
      </div>
      <div>
        <label for="name">Inn:</label>
        <input type="text" v-model="company.inn" required>
      </div>
      <div>
        <label for="name">Address:</label>
        <input type="text" v-model="company.address" required>
      </div>
      <button type="submit">{{ isEditing ? 'Save' : 'Create' }}</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      company: {
        name: '', id: 0, address: '', inn: ''
      }
    };
  },
  computed: {
    isEditing() {
      return this.company.id !== null;
    }
  },
  methods: {
    fetchCompany() {
      axios.get(`http://localhost:8080/api/v1/company/${this.company.id}`)
          .then(response => {
            this.company = response.data;
          })
          .catch(error => {
            console.error("There was an error fetching the company!", error);
          });
    },
    submitForm() {
      if (this.isEditing) {
        axios.patch(`http://localhost:8080/api/v1/company/${this.company.id}/edit`, this.company)
            .then(() => {
              this.$router.push({ name: 'CompanyList' });
            })
            .catch(error => {
              console.error("There was an error updating the company!", error);
            });
      } else {
        axios.post('http://localhost:8080/api/v1/company/new', this.company)
            .then(() => {
              this.$router.push({ name: 'CompanyList' });
            })
            .catch(error => {
              console.error("There was an error creating the company!", error);
            });
      }
    }
  },
  created() {
    if (this.isEditing) {
      this.fetchCompany();
    }
  }
};
</script>
