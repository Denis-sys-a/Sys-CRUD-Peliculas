async function eliminarPelicula(id) {
  if (!confirm("¿Deseas eliminar esta película?")) {
    return;
  }

  try {
    const response = await axios.post("acciones/delete.php", { id });
    if (response.data.success) {
      document.querySelector(`#pelicula_${id}`)?.remove();
      return;
    }

    alert(response.data.message || "No se pudo eliminar la película");
  } catch (error) {
    console.error("Error al eliminar la película:", error);
    alert("Error al eliminar la película");
  }
}