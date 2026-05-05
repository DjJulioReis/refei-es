import React, { useState } from 'react';
import { useProducts } from '../../context/ProductContext';
import { Trash2, Edit, Plus, X, Upload, Video, Image as ImageIcon } from 'lucide-react';

const AdminDashboard = () => {
  const { products, addProduct, updateProduct, deleteProduct } = useProducts();
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [editingProduct, setEditingProduct] = useState(null);
  const [formData, setFormData] = useState({ title: '', description: '', media: [] });

  const handleOpenModal = (product = null) => {
    if (product) {
      setEditingProduct(product);
      setFormData({ title: product.title, description: product.description, media: product.media || [] });
    } else {
      setEditingProduct(null);
      setFormData({ title: '', description: '', media: [] });
    }
    setIsModalOpen(true);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (editingProduct) {
      updateProduct({ ...editingProduct, ...formData });
    } else {
      addProduct(formData);
    }
    setIsModalOpen(false);
  };

  const handleFileUpload = (e) => {
    const files = Array.from(e.target.files);
    files.forEach(file => {
      const reader = new FileReader();
      reader.onloadend = () => {
        const type = file.type.startsWith('video/') ? 'video' : 'image';
        setFormData(prev => ({
          ...prev,
          media: [...prev.media, { url: reader.result, type }]
        }));
      };
      reader.readAsDataURL(file);
    });
  };

  const removeMedia = (index) => {
    setFormData(prev => ({
      ...prev,
      media: prev.media.filter((_, i) => i !== index)
    }));
  };

  return (
    <div className="max-w-7xl mx-auto py-10 px-4">
      <div className="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
        <div className="flex">
          <div className="ml-3">
            <p className="text-sm text-yellow-700">
              <strong>Nota de Demonstração:</strong> Esta versão utiliza armazenamento local (localStorage).
              Evite enviar vídeos pesados ou muitas fotos em alta resolução, pois há um limite de ~5MB no navegador.
              Em produção, seria utilizado um serviço de nuvem como S3 ou Cloudinary.
            </p>
          </div>
        </div>
      </div>

      <div className="flex justify-between items-center mb-10">
        <h1 className="text-3xl font-bold text-primary">Gerenciar Cardápio</h1>
        <button
          onClick={() => handleOpenModal()}
          className="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-primary-dark transition"
        >
          <Plus size={20} /> Novo Produto
        </button>
      </div>

      <div className="bg-white rounded-xl shadow overflow-hidden">
        <table className="min-w-full divide-y divide-gray-200">
          <thead className="bg-gray-50">
            <tr>
              <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
              <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
              <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mídia</th>
              <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
            </tr>
          </thead>
          <tbody className="bg-white divide-y divide-gray-200">
            {products.map((product) => (
              <tr key={product.id}>
                <td className="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{product.title}</td>
                <td className="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{product.description}</td>
                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{product.media?.length || 0} itens</td>
                <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                  <button onClick={() => handleOpenModal(product)} className="text-primary hover:text-primary-dark"><Edit size={18} /></button>
                  <button onClick={() => deleteProduct(product.id)} className="text-red-600 hover:text-red-900"><Trash2 size={18} /></button>
                </td>
              </tr>
            ))}
            {products.length === 0 && (
              <tr>
                <td colSpan="4" className="px-6 py-10 text-center text-gray-500">Nenhum produto cadastrado.</td>
              </tr>
            )}
          </tbody>
        </table>
      </div>

      {/* Modal */}
      {isModalOpen && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-[100]">
          <div className="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto p-8 relative">
            <button onClick={() => setIsModalOpen(false)} className="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
              <X size={24} />
            </button>
            <h2 className="text-2xl font-bold text-primary mb-6">{editingProduct ? 'Editar Produto' : 'Novo Produto'}</h2>

            <form onSubmit={handleSubmit} className="space-y-6">
              <div>
                <label className="block text-sm font-medium text-gray-700">Título</label>
                <input
                  type="text"
                  required
                  className="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md"
                  value={formData.title}
                  onChange={(e) => setFormData({...formData, title: e.target.value})}
                />
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700">Descrição</label>
                <textarea
                  required
                  rows="4"
                  className="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md"
                  value={formData.description}
                  onChange={(e) => setFormData({...formData, description: e.target.value})}
                ></textarea>
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Mídia (Fotos/Vídeos)</label>
                <div className="flex items-center justify-center w-full">
                  <label className="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                    <div className="flex flex-col items-center justify-center pt-5 pb-6">
                      <Upload className="w-8 h-8 text-gray-400 mb-2" />
                      <p className="text-sm text-gray-500">Clique para fazer upload</p>
                    </div>
                    <input type="file" multiple className="hidden" onChange={handleFileUpload} accept="image/*,video/*" />
                  </label>
                </div>

                <div className="grid grid-cols-4 gap-4 mt-4">
                  {formData.media.map((item, index) => (
                    <div key={index} className="relative group aspect-square bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                      {item.type === 'video' ? (
                        <div className="flex items-center justify-center h-full text-primary"><Video size={32} /></div>
                      ) : (
                        <img src={item.url} className="w-full h-full object-cover" />
                      )}
                      <button
                        type="button"
                        onClick={() => removeMedia(index)}
                        className="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition"
                      >
                        <X size={12} />
                      </button>
                    </div>
                  ))}
                </div>
              </div>
              <button
                type="submit"
                className="w-full bg-primary text-white py-3 rounded-md font-bold hover:bg-primary-dark transition"
              >
                {editingProduct ? 'Salvar Alterações' : 'Cadastrar Produto'}
              </button>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};

export default AdminDashboard;
