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


      <!-- CODIGO EN "codigos_posibles_a_usar" -->


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

      <!--<script src="javascript/users.js"></script>-->

    </body>
  </html>
