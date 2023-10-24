<x-app-layout>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Lista de Usuarios -->
                <div class="p-6">                    
                    <h5>{{ __("Lista de Usuarios") }}
                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modalUsuario">
                            Incluir +
                        </button>
                    </h5>

                    @if ($users->isEmpty())
                        <p>Nenhum user cadastrado.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>                                    
                                    <th class="text-sm">Nome</th>
                                    <th class="text-sm">Email</th>
                                    <th class="text-sm">WhatsApp</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-sm">
                                            {{ $user->id . ' - ' }} {{ $user->name }}
                                        </td>
                                        <td class="text-sm">{{ $user->email }}</td>
                                        <td class="text-sm">{{ $user->whatsapp }}</td>                                        
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#editarUsuarioModal{{ $user->id }}">
                                                <i class="fas fa-edit" style="color: #2a45cc; font-size: 20px;"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#excluirUsuarioModal{{ $user->id }}">
                                                <i class="fa-solid fa-trash" style="color: #df1616; font-size: 20px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    
                                    <div class="modal fade" id="excluirUsuarioModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="excluirUsuarioModal{{ $user->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="excluirUsuarioModal{{ $user->id }}Label">Confirmar Exclusão</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza de que deseja excluir o Usuario {{ $user->name }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal de Edição do Usuario -->
                                    <div class="modal fade" id="editarUsuarioModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editarUsuarioModal{{ $user->id }}Label" aria-hidden="true">                                    
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarUsuarioModal{{ $user->id }}Label">Editar Usuario</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">                                                        
                                                        <div class="form-group">
                                                            <label for="name">Nome</label>
                                                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="email" class="form-control" id="email" name="email" placeholder="exemplo@dominio.com" value="{{ $user->email }}" required>
                                                            <span id="email-validation-message"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="whatsapp">WhatsApp</label>
                                                            <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ $user->whatsapp }}" placeholder="(99) 9XXXX-XXXX" required>
                                                            <span id="whatsapp-validation-message"></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="password" class="form-label">Senha</label>
                                                            <input type="password" class="form-control" id="password" name="password" required>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label for="password_confirmation" class="form-label">Confirmação de Senha</label>
                                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                        <button type="submit" class="btn btn-success">Salvar Alterações</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>                                
                                @endforeach
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('erro'))
                                    <div class="alert alert-danger">
                                        {{ session('erro') }}
                                    </div>
                                @endif

                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    $(document).ready(function() {
                                        // Função de validação para email e whatsapp
                                        function validateInput(inputField, regex, validationMessageId, validMessage, invalidMessage) {
                                            inputField.on("input", function() {
                                                if (regex.test($(this).val())) {
                                                    $(validationMessageId).text(validMessage).css("color", "green");
                                                } else {
                                                    $(validationMessageId).text(invalidMessage).css("color", "red");
                                                }
                                            });
                                        }
                                
                                        // Expressões regulares para email e whatsapp
                                        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                                        var whatsappRegex = /^\(\d{2}\)\s9\d{4}-\d{4}$/;
                                
                                        // Validação de email
                                        validateInput($("#email"), emailRegex, "#email-validation-message", "Formato de Email válido", "Formato de Email inválido");
                                
                                        // Validação de WhatsApp
                                        validateInput($("#whatsapp"), whatsappRegex, "#whatsapp-validation-message", "Formato de WhatsApp válido", "Formato de WhatsApp inválido");
                                    });
                                </script>
                                
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
  
    <!-- Modal -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUsuarioLabel">Cadastro de Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="exemplo@dominio.com" name="email" required>
                            <span id="email-validation-message"></span>
                        </div>
                        <div class="mb-3">
                            <label for="whatsapp" class="form-label">WhatsApp</label>
                            <input type="text" class="form-control" id="whatsapp" placeholder="(99) 9XXXX-XXXX" name="whatsapp" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmação de Senha</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>      
        

    
</x-app-layout>
