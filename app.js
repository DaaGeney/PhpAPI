var app = new Vue({

	el: "#root",
	data: {
		//Declaramos todas las variables que se van a utilizar
		showingModal: false,
		showingRolModal: false,

		showingeditModal: false,
		showingRoleditModal: false,

		showingdeleteModal: false,
		showingRoldeleteModal: false,

		errorUserMessage: "",
		successUserMessage: "",
		errorRolMessage: "",
		successRolMessage: "",

		users: [],
		newUser: { id: "", nombre: "", apellido: "", correo: "", clave: "", credencial: "", idlista: "", idprograma: "" },
		clickedUser: {},
		id:"",

		roles: [],
		newRol: {id: "", nombre: "", descripcion: ""},
		clickedRol: {},

	},
	//Funciones iniciales (Se ejecutan al iniciar)
	mounted: function () {
		this.getAllUsers();
		this.getAllRoles();
	},
	methods: {
		//Trae todos los usuarios de la base de datos
		getAllUsers: function () {
			
			axios.get("http://localhost/software/api.php?action=readusers")
				.then(function (response) {
					console.log(response.data)
					if (response.data.error) {
						app.errorUserMessage = response.data.message;
						console.log(app.users)
					} else {
						app.users = response.data.users;
						console.log(app.users)
					}
					//
					
					
				});
		},
		getOneUser:function(){
			//console.log("Al menos entra" )
			var formData = app.toFormData(app.id)
			console.log("Al menos entra +" + formData)
			axios.post("http://localhost/software/api.php?action=search", formData)
				.then(function (response) {
					console.log(response.data)
					app.id=""
					if (response.data.error) {
						app.errorMessage = response.data.message;
						console.log("error")
					} else {
						app.users = response.data.users;
						console.log("Entro")
					}
				});
		},
		//Trae todos los roles de la base de datos
		getAllRoles: function () {
			
			axios.get("http://localhost/software/api.php?action=readroles")
				.then(function (response) {
					console.log(response.data)
					if (response.data.error) {
						app.errorRolMessage = response.data.message;
						console.log(app.roles)
					} else {
						app.roles = response.data.roles;
						console.log(app.roles)
					}
					//
					
					
				});
		},
		//Crea un nuevo usuario en la tabla usuarios
		saveUser: function () {
 
			var formData = app.toFormData(app.newUser);
			axios.post("http://localhost/software/api.php?action=createuser", formData)
				.then(function (response) {
					console.log(response);
					app.newUser = { id: "", nombre: "", apellido: "", correo: "", clave: "", credencial: "", idlista: "", idprograma: "" };
					console.log(app.newUser)
					if (response.data.error) {
						app.errorUserMessage = response.data.message;
						//console.log(response.data.message)
					} else {
						console.log("entro melo")
						app.successUserMessage = response.data.message;
						app.getAllUsers();
					}
				});
		},
		//Crea un nuevo rol en la tabla roles
		saveRol: function () {

			var formData = app.toFormData(app.newRol);
			axios.post("http://localhost/software/api.php?action=createrol", formData)
				.then(function (response) {
					console.log(response);
					app.newRol = { id: "", nombre: "", descripcion: ""};
					console.log(app.newRol)
					if (response.data.error) {
						app.errorRolMessage = response.data.message;
						//console.log(response.data.message)
					} else {
						console.log("entro melo")
						app.successRolMessage = response.data.message;
						app.getAllRoles();
					}
				});
		},
		//Actualiza un usuario dependiendo del id de este
		updateUser: function () {

			var formData = app.toFormData(app.clickedUser);
			axios.post("http://localhost/software/api.php?action=updateuser", formData)
				.then(function (response) {
					console.log(response);
					app.clickedUser = {};
					if (response.data.error) {
						app.errorUserMessage = response.data.message;
					} else {
						app.successUserMessage = response.data.message;
						app.getAllUsers();
					}
				});
		},
		//Actualiza un rol dependiendo del id de este
		updateRol: function () {

			var formData = app.toFormData(app.clickedRol);
			axios.post("http://localhost/software/api.php?action=updaterol", formData)
				.then(function (response) {
					console.log(response);
					app.clickedRol = {};
					if (response.data.error) {
						app.errorRolMessage = response.data.message;
					} else {
						app.successRolMessage = response.data.message;
						app.getAllRoles();
					}
				});
		},
		//Elimina un usuario dependiendo del id de este
		deleteUser: function () {

			var formData = app.toFormData(app.clickedUser);
			axios.post("http://localhost/software/api.php?action=deleteuser", formData)
				.then(function (response) {
					console.log(response);
					app.clickedUser = {};
					if (response.data.error) {
						app.errorUserMessage = response.data.message;
					} else {
						app.successUserMessage = response.data.message;
						app.getAllUsers();
					}
				});
		},
		//Elimina un Rol dependiendo del id de este
		deleteRol: function () {

			var formData = app.toFormData(app.clickedRol);
			axios.post("http://localhost/software/api.php?action=deleterol", formData)
				.then(function (response) {
					console.log(response);
					app.clickedRol = {};
					if (response.data.error) {
						app.errorRolMessage = response.data.message;
					} else {
						app.successRolMessage = response.data.message;
						app.getAllRoles();
					}
				});
		},
		//Establece el usuario seleccionado
		selectUser(user) {
			app.clickedUser = user;
		},
		//Establece el rol seleccionado
		selectRol(rol) {
			app.clickedRol = rol;
		},
		//Traduce los datos a la tabla
		toFormData: function (obj) {
			var form_data = new FormData();
			for (var key in obj) {
				form_data.append(key, obj[key]);
			}
			return form_data;
		},
		//Limpia los mensajes de las notificaciones
		clearMessage: function () {
			app.errorUserMessage = "";
			app.successUserMessage = "";
			app.errorRolMessage = "";
			app.successRolMessage = "";
		},
	}
});