<template>
  <div>
    <h1>Companies</h1>
    <ul>
      <li v-for="company in companies" :key="company.id">
        {{ company.name }}
        {{ company.inn }}
        {{ company.address }}
        <button @click="editCompany(company.id)">Edit</button>
        <button @click="deleteCompany(company.id)">Delete</button>
      </li>
    </ul>
    <button @click="newCompany()">Add New Company</button>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      companies: []
    };
  },
  methods: {
    fetchCompanies() {
      axios.get('http://localhost:8080/api/v1/company')
          .then(response => {
            this.companies = response.data;
          })
          .catch(error => {
            console.error("There was an error fetching the companies!", error);
          });
    },
    newCompany() {
      this.$router.push({ name: 'CompanyNew' });
    },
    editCompany(id) {
      this.$router.push({ name: 'CompanyEdit', params: { id } });
    },
    deleteCompany(id) {
      axios.delete(`http://localhost:8080/api/v1/company/${id}`)
          .then(() => {
            this.fetchCompanies();
          })
          .catch(error => {
            console.error("There was an error deleting the company!", error);
          });
    }
  },
  created() {
    this.fetchCompanies();
  }
};
</script>