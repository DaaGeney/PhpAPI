var app = new Vue({

	el: "#root",
	data: {
		showingModal: false,
		showingeditModal: false,
		showingdeleteModal: false,
		errorMessage: "",
		successMessage: "",
		users: [],
		newUser: { id: "", nombre: "", apellido: "", correo: "", clave: "", credencial: "", idlista: "", idprograma: "" },
		clickedUser: {},


	},
	mounted: function () {
		this.getAllUsers();
	},
	methods: {
		getAllUsers: function () {
			
			axios.get("http://localhost/software/api.php?action=read")
				.then(function (response) {
					console.log(response.data)
					if (response.data.error) {
						app.errorMessage = response.data.message;
						console.log(app.users)
					} else {
						app.users = response.data.users;
						console.log(app.users)
					}
					//
					
					
				});
		},
		saveUser: function () {

			var formData = app.toFormData(app.newUser);
			axios.post("http://localhost/software/api.php?action=create", formData)
				.then(function (response) {
					console.log(response);
					app.newUser = { id: "", nombre: "", apellido: "", correo: "", clave: "", credencial: "", idlista: "", idprograma: "" };
					console.log(app.newUser)
					if (response.data.error) {
						app.errorMessage = response.data.message;
						//console.log(response.data.message)
					} else {
						console.log("entro melo")
						app.successMessage = response.data.message;
						app.getAllUsers();
					}
				});
		},
		updateUser: function () {

			var formData = app.toFormData(app.clickedUser);
			axios.post("http://localhost/vuekk/api.php?action=update", formData)
				.then(function (response) {
					console.log(response);
					app.clickedUser = {};
					if (response.data.error) {
						app.errorMessage = response.data.message;
					} else {
						app.successMessage = response.data.message;
						app.getAllUsers();
					}
				});
		},
		deleteUser: function () {

			var formData = app.toFormData(app.clickedUser);
			axios.post("http://localhost/vuekk/api.php?action=delete", formData)
				.then(function (response) {
					console.log(response);
					app.clickedUser = {};
					if (response.data.error) {
						app.errorMessage = response.data.message;
					} else {
						app.successMessage = response.data.message;
						app.getAllUsers();
					}
				});
		},
		selectUser(user) {
			app.clickedUser = user;
		},

		toFormData: function (obj) {
			var form_data = new FormData();
			for (var key in obj) {
				form_data.append(key, obj[key]);
			}
			return form_data;
		},
		clearMessage: function () {
			app.errorMessage = "";
			app.successMessage = "";
		},

	}
});