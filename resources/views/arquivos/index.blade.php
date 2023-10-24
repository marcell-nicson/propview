<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Lista de Arquivos -->
                <div class="p-6">                    
                    <h5>{{ __("Lista de Arquivos") }}
                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modalArquivo">
                            Incluir +
                        </button>
                    </h5>

                    @if ($arquivos->isEmpty())
                        <p>Nenhum arquivo cadastrado.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>                                    
                                    <th class="text-sm">Titulo</th>
                                    <th class="text-sm">Descrição</th>
                                    <th class="text-sm">Tipo</th>
                                    <th class="text-sm">URL</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($arquivos as $arquivo)
                                    <tr>
                                        <td class="text-sm">
                                            {{ $arquivo->id . ' - ' }} {{ $arquivo->titulo }}
                                        </td>
                                        <td class="text-sm">{{ $arquivo->descricao }}</td>
                                        <td class="text-sm">{{ $arquivo->tipo }}</td>
                                        <td class="text-sm">{{ $arquivo->url }}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#editarArquivoModal{{ $arquivo->id }}">
                                                <i class="fas fa-edit" style="color: #2a45cc; font-size: 20px;"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#excluirArquivoModal{{ $arquivo->id }}">
                                                <i class="fa-solid fa-trash" style="color: #df1616; font-size: 20px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    
                                    <div class="modal fade" id="excluirArquivoModal{{ $arquivo->id }}" tabindex="-1" role="dialog" aria-labelledby="excluirArquivoModal{{ $arquivo->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="excluirArquivoModal{{ $arquivo->id }}Label">Confirmar Exclusão</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza de que deseja excluir o Arquivo {{ $arquivo->nome }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('arquivos.destroy', $arquivo->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal de Edição do Arquivo -->
                                    <div class="modal fade" id="editarArquivoModal{{ $arquivo->id }}" tabindex="-1" role="dialog" aria-labelledby="editarArquivoModal{{ $arquivo->id }}Label" aria-hidden="true">                                    
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarArquivoModal{{ $arquivo->id }}Label">Editar Arquivo</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('arquivos.update', $arquivo->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="titulo">Título</label>
                                                                <input type="text" class="form-control" id="titulo" name="nome" value="{{ $arquivo->titulo }}" required>
                                                            </div>                                                        
                                                            <div class="form-group">
                                                                <label for="descricao" class="form-label">Descrição</label>
                                                                <textarea class="form-control" id="descricao" name="descricao" rows="4" required>{{ $arquivo->descricao }}</textarea>
                                                            </div>                                                        
                                                            <div class="form-group">
                                                                <label for="arquivo">Arquivo:</label>
                                                                <input type="file" name="arquivo" id="arquivo" class="form-control" >
                                                            </div>
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
                                
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
  
    <!-- Modal -->
    <div class="modal fade" id="modalArquivo" tabindex="-1" role="dialog" aria-labelledby="modalArquivoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalArquivoLabel">Cadastro de Arquivo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('arquivos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" name="titulo" id="titulo" class="form-control">
                        </div>
                    
                        <div class="form-group">
                            <label for="descricao">Descrição:</label>
                            <textarea name="descricao" id="descricao" class="form-control"></textarea>
                        </div>
                    
                        <div class="form-group">
                            <label for="arquivo">Arquivo:</label>
                            <input type="file" name="arquivo" id="arquivo" class="form-control-file">
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
