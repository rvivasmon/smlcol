          <!-- Control Sidebar -->
          <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
              <h5>Title</h5>
              <p>Sidebar content</p>
            </div>
          </aside>
          <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
              <!-- To the right -->
              <div class="float-right d-none d-sm-inline-block">
                Version 1.2
              </div>
              <!-- Default to the left -->
              <strong>Copyright &copy; <?=$anio_actual;?> <a href="https://smartledcolombia.com">SmartLed Colombia</a>.</strong> All rights reserved.
        </footer>

        <aside class="control-sidebar control-sidebar-dark" style="display: none; top: auto; height: auto;">

        </aside>

        <div id="sidebar-overlay">

        </div>
      </div>
      <!-- ./wrapper -->

      <script>
      // JavaScript para evitar el cierre automático del menú al hacer clic en los elementos con la clase 'menu-item'
      document.addEventListener('DOMContentLoaded', function() {
        var menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(function(item) {
          item.addEventListener('click', function(event) {
            event.stopPropagation(); // Evita que el evento de clic se propague al elemento padre
          });
        });
      });
      </script>

      <!-- jQuery -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <!-- Bootstrap -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
      <!-- AdminLTE -->
      <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
      
      <!-- DataTables -->
      <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

      <!-- SweetAlert2 -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

      <!-- Contador de notificaciones -->
      <script>
          function actualizarNotificaciones() {
              $.ajax({
                  url: "<?php echo $URL; ?>admin/help/chat/php/backend.php", // Ruta corregida
                  type: "GET",
                  dataType: "json",
                  success: function(response) {
                      let contadorElement = $("#contadorNotificaciones");
                      let listaNotificaciones = $("#listaNotificaciones");

                      if (response.status === "success" && response.total_unread_count > 0) {
                          contadorElement.text(response.total_unread_count).show();
                          listaNotificaciones.html('');
                          response.notificaciones.forEach(notificacion => {
                              listaNotificaciones.append(`
                                  <a href="#" class="dropdown-item">
                                      <strong>${notificacion.usuario}</strong>: ${notificacion.mensaje}
                                      <span class="float-right text-muted text-sm">${notificacion.fecha}</span>
                                  </a>
                                  <div class="dropdown-divider"></div>
                              `);
                          });
                      } else {
                          contadorElement.hide();
                          listaNotificaciones.html('<p class="text-muted text-center">No hay nuevas notificaciones</p>');
                      }
                  },
                  error: function(xhr, status, error) {
                      console.error("Error al obtener notificaciones:", error);
                      console.log("Detalles:", xhr.responseText);
                  }
              });
          }

          window.addEventListener("message", function(event) {
              if (event.data.tipo === "notificacion") {
                  let contadorElement = $("#contadorNotificaciones");
                  let listaNotificaciones = $("#listaNotificaciones");
                  let totalNotificaciones = parseInt(contadorElement.text()) || 0;
                  totalNotificaciones += 1;
                  contadorElement.text(totalNotificaciones).show();
                  listaNotificaciones.prepend(`
                      <a href="#" class="dropdown-item">
                          <strong>${event.data.usuario}</strong>: ${event.data.mensaje}
                          <span class="float-right text-muted text-sm">Ahora</span>
                      </a>
                      <div class="dropdown-divider"></div>
                  `);
              }
          });

          setInterval(actualizarNotificaciones, 5000);
      </script>

      <!-- generador de alertas -->
      <script>
          let previousUnreadCount = parseInt(localStorage.getItem("unreadMessages")) || 0;

          function playNotificationSound() {
              const notificationSound = new Audio("../../admin/help/chat/php/sonido/tono.mp3");
              notificationSound.play();
          }

          function showUnreadMessagesAlertWithSound(unreadCount) {
              playNotificationSound();
              Swal.fire({
                  title: "Nuevo mensaje",
                  text: `Tienes ${unreadCount} mensaje(s) no leído(s).`,
                  icon: "info",
                  confirmButtonText: "Ir al chat",
                  showCancelButton: true,
                  cancelButtonText: "Cerrar",
                  customClass: {
                      popup: 'custom-swal-popup',
                      confirmButton: 'custom-swal-confirm',
                      cancelButton: 'custom-swal-cancel'
                  }
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.href = "../../admin/help/index.php";
                  }
              });
          }

          function actualizarNotificaciones() {
              $.ajax({
                  url: "<?php echo $URL; ?>admin/help/chat/php/backend.php",
                  type: "GET",
                  dataType: "json",
                  success: function(response) {
                      let contadorElement = $("#contadorNotificaciones");
                      let listaNotificaciones = $("#listaNotificaciones");

                      if (response.status === "success") {
                          let newUnreadCount = response.total_unread_count;

                          // 🔥 **NUEVO: Verificar si hay más notificaciones que antes**
                          if (newUnreadCount > previousUnreadCount) {
                              localStorage.setItem("unreadMessages", newUnreadCount);
                              showUnreadMessagesAlertWithSound(newUnreadCount);
                          } 

                          // 🔥 **NUEVO: Guardar la cantidad de notificaciones actual para la siguiente verificación**
                          previousUnreadCount = newUnreadCount;
                      }
                  },
                  error: function(xhr, status, error) {
                      console.error("Error al obtener notificaciones:", error);
                      console.log("Detalles:", xhr.responseText);
                  }
              });
          }

          // Ejecutar cada 5 segundos
          setInterval(actualizarNotificaciones, 5000);
      </script>

        <style>
            .custom-swal-popup {
                background-color: #EEEEEE !important;
                color: rgb(12, 11, 11) !important;
                border-radius: 10px;
            }

            .custom-swal-confirm {
                background-color: rgb(0, 181, 69) !important;
                color: white !important;
                border-radius: 5px;
            }

            .custom-swal-cancel {
                background-color: rgb(245, 40, 4) !important;
                color: white !important;
                border-radius: 5px;
            }
        </style>
      <!-- fin -->

      <script src="javascript/users.js"></script>

    </body>
  </html>
