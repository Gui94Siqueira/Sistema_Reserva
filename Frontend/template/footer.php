<footer>
  <p>Desenvolvido By Students &copy; TI 04 Senac Tito - 2024</p>
</footer>
<script src="assets/js/mdb.umd.min.js"></script>

<script>
  const myModal = document.getElementById('myModal')
  const myInput = document.getElementById('myInput')

  myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus()
  })
</script>


</body>

</html>