<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Lista de visitas -->
                <div class="p-6">                    
                    <h5>{{ __("Lista de Visitas") }}
                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modalvisita">
                            Incluir +
                        </button>                        

                    </h5>
                    
                    @if ($visitas->isEmpty())
                        <p>Nenhum visita cadastrado.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>                                    
                                    <th class="text-sm">Imovel</th>
                                    <th class="text-sm">Nome do Corretor</th>
                                    <th class="text-sm">Nome do Cliente</th>
                                    <th class="text-sm">data</th>
                                    <th class="text-center">status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($visitas as $visita)
                                    <tr>                                        
                                        <td class="text-sm"> {{ $visita->id . ' - ' }} {{ $visita->imovel ? $visita->imovel->titulo : '' }}</td>
                                        <td class="text-sm">{{ $visita->corretor ? $visita->corretor->nome : ''}}</td>
                                        <td class="text-sm">{{ $visita->cliente ? $visita->cliente->nome : ''}}</td>
                                        <td class="text-sm">{{ $visita->data_visita }}</td> 
                                        <td class="text-center">
                                            @php
                                                $status = $visita->statusVisita($visita->status);
                                            @endphp
                                            <span class="badge text-center {{ $status['color'] }}"> {{ $visita['status'] }}</span>
                                        </td>                                        
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#editarvisitaModal{{ $visita->id }}">
                                                <i class="fas fa-edit" style="color: #2a45cc; font-size: 20px;"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#excluirvisitaModal{{ $visita->id }}">
                                                <i class="fa-solid fa-trash" style="color: #df1616; font-size: 20px;"></i>
                                            </a>
                                        </td>
                                    </tr>                               
                                    
                                        <div class="modal fade" id="excluirvisitaModal{{ $visita->id }}" tabindex="-1" role="dialog" aria-labelledby="excluirvisitaModal{{ $visita->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="excluirvisitaModal{{ $visita->id }}Label">Confirmar Exclusão</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza de que deseja excluir o visita {{ $visita->nome }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('visita.destroy', $visita->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal de Edição do visita -->
                                    <div class="modal fade" id="editarvisitaModal{{ $visita->id }}" tabindex="-1" role="dialog" aria-labelledby="editarvisitaModal{{ $visita->id }}Label" aria-hidden="true">                                    
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarvisitaModal{{ $visita->id }}Label">Editar visita</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('visita.update', $visita->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')                                                       
                                                       
                                                        <div class="form-group">
                                                            <label for="corretor_id">Corretor</label>
                                                            <select name="corretor_id" id="corretor_id" class="form-control select 2" required>
                                                                @foreach ($corretores as $corretor)
                                                                    <option value="{{ $corretor->id }}" @if($visita->corretor_id == $corretor->id) selected @endif>{{ $corretor->nome }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> 
                                                        <div class="form-group">
                                                            <label for="cliente_id">Cliente</label>
                                                            <select name="cliente_id" id="cliente_id" class="form-control" required>
                                                                @foreach ($clientes as $cliente)
                                                                    <option value="{{ $cliente->id }}" @if($visita->cliente_id == $cliente->id) selected @endif>{{ $cliente->nome }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="imovel_id">Imóvel</label>
                                                            <select name="imovel_id" id="imovel_id" class="form-control" required>
                                                                @foreach ($imoveis as $imovel)
                                                                    <option value="{{ $imovel->id }}" @if($visita->imovel_id == $imovel->id) selected @endif>{{ $imovel->titulo }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="data_visita">Data e Hora da Visita</label>
                                                            <input type="datetime-local" class="form-control" id="data_visita" name="data_visita" value="{{ $visita->data }}" required>
                                                        </div>                                                        
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select name="status" id="status" class="form-control" required>
                                                                <option value="AGENDADO" @if($visita->status === "AGENDADO") selected @endif>AGENDADO</option>
                                                                <option value="NÃO REALIZADO" @if($visita->status === "NÃO REALIZADO") selected @endif>NÃO REALIZADO</option>
                                                                <option value="REALIZADO" @if($visita->status === "REALIZADO") selected @endif>REALIZADO</option>
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                                        </div>
                                                    </form>
                                                </div>
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
  
    <div class="modal fade" id="modalvisita" tabindex="-1" role="dialog" aria-labelledby="modalVisitaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVisitaLabel">Cadastro de Visita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('visita.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="corretor_id">Corretor</label>
                            <select name="corretor_id" id="corretor_id" class="form-control" required>
                                @foreach ($corretores as $corretor)
                                    <option value="{{ $corretor->id }}">{{ $corretor->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cliente_id">Cliente</label>
                            <select name="cliente_id" id="cliente_id" class="form-control" required>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="imovel_id">Imóvel</label>
                            <select name="imovel_id" id="imovel_id" class="form-control" required>
                                @foreach ($imoveis as $imovel)
                                    <option value="{{ $imovel->id }}">{{ $imovel->titulo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="data_visita">Data e Hora da Visita</label>
                            <input type="datetime-local" class="form-control" id="data_visita" name="data_visita" required>
                        </div>                        
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="AGENDADO">AGENDADO</option>
                                <option value="NÃO REALIZADO">NÃO REALIZADO</option>
                                <option value="REALIZADO">REALIZADO</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    </div>

   
</x-app-layout>
