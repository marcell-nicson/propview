<x-app-layout>
  <x-slot name="header">

      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Calendário de Visitas') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6">
                  <div class="container">
                      <div class="row">
                          <div class="col-12">
                              <div class="col-md-10 offset-1 mt-5 mb-5">
                                  <div id="calendar"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

 
  

    <x-slot name="js">

       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" 
       integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" 
       crossorigin="anonymous" referrerpolicy="no-referrer"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
                
        <script>
            
            $(document).ready(function() {
                $('#calendar').fullCalendar({
                    locale: 'pt-br',
                    refetchResourcesOnNavigate: true,
                    events: '{{ route('calendario.events') }}',
                });
            });
        </script>
    </x-slot>

    <x-slot name="css">
        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" rel="stylesheet">

    </x-slot>

</x-app-layout>
